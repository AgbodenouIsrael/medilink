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
            'zone' => 'nullable|string|max:255',
            // Force: 8 caractères, au moins 1 lettre, 1 chiffre
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()], 
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
            'zone' => $validatedData['zone'] ?? null,
            'password' => Hash::make($request->password),
        ]);

        // 3. Connexion immédiate
        Auth::guard('web')->login($patient);

        // 4. Redirection
        return redirect()->route('dashboard_patient')->with('success', 'Bienvenue sur Medilink !');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Laravel cherche 'password' dans la BDD automatiquement
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard_patient');
        }

        return back()->withErrors([
            'email' => 'Identifiants incorrects.',
        ])->onlyInput('email');
    }
}