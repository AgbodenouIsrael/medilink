<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\Medecin;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class HopitalController extends Controller
{
    public function create()
    {
        $zones = Zone::all();
        return view('inscription_hopitaux', compact('zones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hopitals',
            'contact' => 'required|string|max:20',
            'adresse' => 'required|string',
            'zone_id' => 'required|exists:zones,id',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'fichier_enregistrement_path' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        $path = $request->file('fichier_enregistrement_path')->store('hopitaux_docs', 'public');

        $hopital = Hopital::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'contact' => $request->contact,
            'adresse' => $request->adresse,
            'zone_id' => $request->zone_id,
            'password' => Hash::make($request->password),
            'fichier_enregistrement_path' => $path,
            'statut' => 'en_attente',
        ]);

        Auth::guard('hopital')->login($hopital);

        return redirect()->route('hopital.pending');
    }

    // Page en attente
    public function pending()
    {
        return view('hopital_pending');
    }

    // Dashboard
    public function dashboard()
    {
        $hopital = Auth::guard('hopital')->user();

        if ($hopital->statut === 'en_attente') {
            return redirect()->route('hopital.pending');
        }

        $medecinsCount = $hopital->medecins()->count();
        $patientsCount = $hopital->patients()->count();

        return view('dashboard_hopital', compact('hopital', 'medecinsCount', 'patientsCount'));
    }

    // Liste des médecins affiliés
    public function medecins()
    {
        $hopital = Auth::guard('hopital')->user();
        if ($hopital->statut === 'en_attente')
            return redirect()->route('hopital.pending');

        $medecins = $hopital->medecins()->wherePivot('statut', 'actif')->get();
        $pending = $hopital->medecins()->wherePivot('statut', 'en_attente')->get();

        return view('liste_medecins_hopital', compact('medecins', 'pending'));
    }

    // Approuver un médecin
    public function approveMedecin($id)
    {
        $hopital = Auth::guard('hopital')->user();
        $hopital->medecins()->updateExistingPivot($id, ['statut' => 'actif']);

        return back()->with('success', 'Médecin approuvé avec succès.');
    }

    // Rejeter un médecin
    public function rejectMedecin($id)
    {
        $hopital = Auth::guard('hopital')->user();
        $hopital->medecins()->detach($id);

        return back()->with('success', 'Demande d\'affiliation rejetée.');
    }

    // Liste des patients (hospitalisés/suivis)
    public function patients()
    {
        $hopital = Auth::guard('hopital')->user();
        if ($hopital->statut === 'en_attente')
            return redirect()->route('hopital.pending');

        $patients = $hopital->patients; // Uses the relationship defined in model
        return view('liste_patients_hopital', compact('patients'));
    }

    // Profil Hôpital
    public function profil()
    {
        $hopital = Auth::guard('hopital')->user();
        return view('profil_hopital', compact('hopital'));
    }
}
