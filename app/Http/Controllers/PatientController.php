<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password; // Pour la sécurité mot de passe

class PatientController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation STRICTE
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            // Interdit les dates futures
            'date_naissance' => 'required|date|before:today',
            'genre' => 'required|in:Homme,Femme,Autre',
            'contact' => 'required|string|max:20', // Contact requis pour un patient
            'email' => 'required|email|unique:patients,email',
            'adresse' => 'nullable|string|max:255',
            'zone_id' => 'nullable|exists:zones,id',
            // Force: 8 caractères, au moins 1 lettre, 1 chiffre
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'privacy_policy' => 'accepted',
        ]);

        // 2. Création (Le hachage se fait ici)
        $patient = Patient::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'date_naissance' => $validatedData['date_naissance'],
            'genre' => $validatedData['genre'],
            'contact' => $validatedData['contact'],
            'email' => $validatedData['email'],
            'adresse' => $validatedData['adresse'] ?? null,
            'zone_id' => $validatedData['zone_id'] ?? null,
            'password' => Hash::make($request->password),
        ]);

        // 3. Connexion immédiate
        Auth::guard('patient')->login($patient);

        // Debug : vérifier si l'utilisateur est bien connecté
        if (Auth::check()) {
            \Log::info('Utilisateur connecté après inscription: ' . Auth::user()->email);
        } else {
            \Log::error('Échec de connexion après inscription');
        }
        // Après Auth::guard('patient')->login($patient);
        \Log::info('=== DEBUG AUTHENTICATION ===');
        \Log::info('Patient ID: ' . $patient->id);
        \Log::info('Email: ' . $patient->email);
        \Log::info('Auth::guard(patient)->check(): ' . (Auth::guard('patient')->check() ? 'TRUE' : 'FALSE'));
        \Log::info('Auth::check(): ' . (Auth::check() ? 'TRUE' : 'FALSE'));

        // Test manuel
        $testAuth = Auth::guard('patient')->user();
        \Log::info('Auth user: ' . ($testAuth ? $testAuth->email : 'NULL'));

        // Juste avant la redirection
        session()->put('test_session', 'session_works');

        // 4. Redirection
        return redirect()->route('dashboard_patient')->with('success', 'Bienvenue sur Medilink !');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // ⚠️ CORRECTION ICI : Utiliser le guard 'patient'
        if (Auth::guard('patient')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Debug
            \Log::info('Patient connecté: ' . Auth::guard('patient')->user()->email);

            return redirect()->intended('dashboard_patient');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }

    public function update(Request $request)
    {
        $patient = Auth::user();
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'contact' => 'nullable|string|max:20',
            'email' => 'required|email|unique:patients,email,' . $patient->patient_id . ',patient_id',
            'adresse' => 'nullable|string|max:255',
        ]);

        $patient->update($validatedData);

        return redirect()->back()->with('success', 'Informations mises à jour avec succès !');
    }
}