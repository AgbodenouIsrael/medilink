<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->boolean('remember');

        // 1. Try Medecin
        if (Auth::guard('medecin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard_medecin'));
        }

        // 2. Try Patient
        if (Auth::guard('patient')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard_patient'));
        }

        // 3. Try Hopital
        if (Auth::guard('hopital')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard_hopital'));
        }

        // 4. Try Pharmacie
        if (Auth::guard('pharmacie')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard_pharmacie'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Log out all supported guards
        Auth::guard('medecin')->logout();
        Auth::guard('patient')->logout();
        Auth::guard('hopital')->logout();
        Auth::guard('pharmacie')->logout();
        // Also default web guard if used
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('connexion')->with('success', 'Vous êtes déconnecté.');
    }
}
