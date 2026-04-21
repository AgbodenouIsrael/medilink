<?php

namespace App\Http\Controllers;

use App\Models\Medecin;
use App\Models\Patient;
use App\Models\Hopital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class MedecinController extends Controller
{


    // Formulaire d'inscription
    public function create()
    {
        $specialites = \App\Models\Specialite::all();
        return view('medecin.auth.register', compact('specialites'));
    }

    // Inscription médecin
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:medecins',
            'contact' => 'required|string|max:20',
            'specialite_id' => 'nullable|exists:specialites,id',
            'numero_licence' => 'required|string|unique:medecins',

            'certificat_path' => 'required|file|mimes:pdf,jpg,png|max:2048',
            'password' => 'required|string|min:8|confirmed',
            'privacy_policy' => 'accepted',
        ]);

        $path = $request->file('certificat_path')->store('certificats', 'public');

        $medecin = Medecin::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'contact' => $request->contact,
            'specialite_id' => $request->specialite_id,
            'numero_licence' => $request->numero_licence,
            'certificat_path' => $path,
            'password' => $request->password, // Cast 'hashed' dans le modèle s'en charge
            'statut' => 'en_attente',
        ]);

        Auth::guard('medecin')->login($medecin);

        // Envoyer email à l'admin (simulation ou réel)
        try {
            // Pour l'instant, on n'envoie pas réellement si pas configuré, ou on log
            // Mail::to('admin@medilink.tg')->send(new \App\Mail\NewDoctorRegistration($medecin));
        } catch (\Exception $e) {
            // Ignorer l'erreur d'envoi pour ne pas bloquer l'inscription
        }

        return redirect()->route('medecin.pending');
    }

    // Page en attente de validation
    public function pending()
    {
        return view('medecin.status.pending');
    }

    // Dashboard
    public function dashboard()
    {
        $medecin = Auth::guard('medecin')->user();

        // Redirection si encore en attente
        if ($medecin->statut === 'en_attente') {
            return redirect()->route('medecin.pending');
        }

        $patientsCount = $medecin->patients_autorises()->count();
        // $rdvCount = $medecin->rendezVous()->where('statut', 'planifie')->count(); // À venir

        return view('medecin.dashboard', compact('medecin', 'patientsCount'));
    }

    // Liste des patients
    public function mesPatients(Request $request)
    {
        $medecin = Auth::guard('medecin')->user();
        $query = $medecin->patients_autorises();

        if ($request->has('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                    ->orWhere('prenom', 'like', "%{$search}%");
            });
        }

        $patients = $query->get();

        return view('medecin.patients.index', compact('patients'));
    }

    // Détails patient et ajout consultation
    public function showPatient($id)
    {
        $medecin = Auth::guard('medecin')->user();
        $patient = Patient::with(['antecedents', 'allergies', 'ordonnances', 'documents'])->findOrFail($id);

        // Vérification autorisation
        if (!$medecin->patients_autorises()->where('patients.id', $id)->exists()) {
            abort(403, 'Accès non autorisé à ce dossier patient.');
        }

        $historique = \App\Models\ConsultationHistorique::where('patient_id', $id)
            ->with('medecin')
            ->latest('date_consultation')
            ->get();

        return view('medecin.patient_show', compact('patient', 'historique'));
    }

    // Enregistrer une consultation
    public function storeConsultation(Request $request, $id)
    {
        $medecin = Auth::guard('medecin')->user();

        // Vérification autorisation (écriture)
        $auth = \App\Models\Autorisation::where('medecin_id', $medecin->id)
            ->where('patient_id', $id)
            ->where('statut', 'approuve')
            ->first();

        if (!$auth || !in_array($auth->type_acces, ['ecriture', 'complet'])) {
            abort(403, 'Droits d\'écriture requis.');
        }

        $request->validate([
            'diagnostic' => 'required|string',
            'ordonnance' => 'nullable|string',
        ]);

        \App\Models\ConsultationHistorique::create([
            'patient_id' => $id,
            'medecin_id' => $medecin->id,
            'date_consultation' => now(),
            'diagnostic' => $request->diagnostic,
            'ordonnance' => $request->ordonnance,
        ]);

        return back()->with('success', 'Consultation enregistrée.');
    }

    // Gestion des hôpitaux
    public function mesHopitaux()
    {
        $medecin = Auth::guard('medecin')->user();
        $hopitaux = $medecin->hopitals; // Relation à définir dans le modèle Medecin
        $allHopitaux = Hopital::where('statut', 'verifie')->get();

        return view('medecin.hospitals.index', compact('hopitaux', 'allHopitaux'));
    }

    // Profil médecin
    public function profil()
    {
        $medecin = Auth::guard('medecin')->user();
        $medecin->load('specialite'); // Charger la relation
        return view('medecin.profile', compact('medecin'));
    }

    public function joinHopital(Request $request)
    {
        $request->validate(['hopital_id' => 'required|exists:hopitals,id']);

        $medecin = Auth::guard('medecin')->user();
        $medecin->hopitals()->syncWithoutDetaching([
            $request->hopital_id => [
                'role' => 'Medecin Associé',
                'statut' => 'en_attente'
            ]
        ]);

        return back()->with('success', 'Demande d\'affiliation envoyée. En attente de validation par l\'hôpital.');
    }

    public function update(Request $request, Medecin $medecin)
    {
        //
    }

    public function destroy(Medecin $medecin)
    {
        //
    }
}
