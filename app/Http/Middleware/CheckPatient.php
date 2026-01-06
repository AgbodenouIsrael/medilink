<?php

// app/Http/Middleware/CheckPatient.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPatient
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('patient')->check()) {
            return redirect()->route('connexion')->with('error', 'Accès réservé aux patients.');
        }
        return $next($request);
    }
}
