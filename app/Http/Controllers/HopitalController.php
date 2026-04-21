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
        $zones = \App\Models\Zone::all();
        $specialties = \App\Models\Specialite::orderBy('nom')->get();
        return view('hopital.auth.register', compact('zones', 'specialties'));
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
            'privacy_policy' => 'accepted',
            'specialites' => 'required|array|min:1',
            'specialites.*' => 'exists:specialites,id',
        ], [
            'specialites.required' => 'Veuillez sélectionner au moins une spécialité.',
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

        // Attach specialties
        $hopital->specialites()->attach($request->specialites);

        Auth::guard('hopital')->login($hopital);

        return redirect()->route('hopital.pending');
    }

    // Page en attente
    public function pending()
    {
        return view('hopital.status.pending');
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

        return view('hopital.dashboard', compact('hopital', 'medecinsCount', 'patientsCount'));
    }

    // Liste des médecins affiliés
    public function medecins()
    {
        $hopital = Auth::guard('hopital')->user();
        if ($hopital->statut === 'en_attente')
            return redirect()->route('hopital.pending');

        $medecins = $hopital->medecins()->wherePivot('statut', 'actif')->get();
        $pending = $hopital->medecins()->wherePivot('statut', 'en_attente')->get();

        return view('hopital.doctors.index', compact('medecins', 'pending'));
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
        return view('hopital.patients.index', compact('patients'));
    }

    // Profil Hôpital
    public function profil()
    {
        $hopital = Auth::guard('hopital')->user();
        return view('hopital.profile', compact('hopital'));
    }

    // Gestion des Spécialités
    public function specialites()
    {
        $hopital = Auth::guard('hopital')->user();

        if ($hopital->statut === 'en_attente') {
            return redirect()->route('hopital.pending');
        }

        $currentSpecialites = $hopital->specialites;
        $allSpecialites = \App\Models\Specialite::orderBy('nom')->get();

        return view('hopital.specialites.index', compact('hopital', 'currentSpecialites', 'allSpecialites'));
    }

    // Ajouter une spécialité
    public function addSpecialite(Request $request)
    {
        $request->validate([
            'specialite_id' => 'required|exists:specialites,id',
            'description' => 'nullable|string|max:500'
        ]);

        $hopital = Auth::guard('hopital')->user();

        // Check if already exists
        if ($hopital->specialites()->where('specialite_id', $request->specialite_id)->exists()) {
            return back()->with('error', 'Cette spécialité est déjà ajoutée.');
        }

        $hopital->specialites()->attach($request->specialite_id, [
            'description' => $request->description
        ]);

        return back()->with('success', 'Spécialité ajoutée avec succès.');
    }

    // Mettre à jour la description d'une spécialité
    public function updateSpecialite(Request $request, $specialiteId)
    {
        $request->validate([
            'description' => 'nullable|string|max:500'
        ]);

        $hopital = Auth::guard('hopital')->user();

        $hopital->specialites()->updateExistingPivot($specialiteId, [
            'description' => $request->description
        ]);

        return back()->with('success', 'Description mise à jour.');
    }

    // Retirer une spécialité
    public function removeSpecialite($specialiteId)
    {
        $hopital = Auth::guard('hopital')->user();
        $hopital->specialites()->detach($specialiteId);

        return back()->with('success', 'Spécialité retirée.');
    }

    // Mettre à jour le profil institutionnel
    public function updateProfil(Request $request)
    {
        $hopital = Auth::guard('hopital')->user();

        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:hopitals,email,' . $hopital->id,
            'contact' => 'required|string|max:20',
            'adresse' => 'required|string',
            'zone_id' => 'required|exists:zones,id',
        ]);

        $hopital->update($request->only(['nom', 'email', 'contact', 'adresse', 'zone_id']));

        return back()->with('success', 'Informations du profil mises à jour avec succès.');
    }
}

