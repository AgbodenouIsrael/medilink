<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'date_naissance' => 'required|date',
            'genre' => 'required|in:Homme,Femme,Autre',
            'contact' => 'nullable|string|max:20',
            'email' => 'required|email|unique:patients,email',
            'adresse' => 'nullable|string|max:255',
            'zone' => 'nullable|string|max:255',
            'mot_de_passe' => 'required|string|min:8',
        ]);

        // 2. Hachage du mot de passe
        $validatedData['mot_de_passe'] = Hash::make($validatedData['mot_de_passe']);

        // --- SUPPRIME LE dd($validatedData) POUR TESTER EN RÉEL ---

        // 3. Création du patient (On ne le fait qu'UNE fois)
        $patient = Patient::create($validatedData);

        Auth::login($patient);

        // 4. Connexion automatique (Optionnel mais recommandé)
        // Note : Pour que cela fonctionne, ton Model Patient doit être configuré pour l'Auth
        // Auth::login($patient); 

        // 5. Redirection unique avec message
        return redirect()->route('dashboard_patient')->with('success', 'Inscription réussie !');
    }

 


    public function login(Request $request)
{
    // 1. Validation des champs saisis
    $credentials = $request->validate([
        'email' => 'required|email',
        'mot_de_passe' => 'required',
    ]);

    // 2. Tentative de connexion
    // On utilise Auth::attempt, mais attention : Laravel cherche 'password' par défaut.
    // Comme ta colonne s'appelle 'mot_de_passe', on fait une petite adaptation :
    
    if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['mot_de_passe']])) {
        // Si ça réussit, on régénère la session pour la sécurité
        $request->session()->regenerate();

        return redirect()->intended('dashboard_patient');
    }

    // 3. Si ça échoue, on revient en arrière avec une erreur
    return back()->withErrors([
        'email' => 'Les identifiants ne correspondent pas à nos enregistrements.',
    ])->onlyInput('email');
} }