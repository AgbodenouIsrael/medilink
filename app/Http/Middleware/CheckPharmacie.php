<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPharmacie
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('pharmacie')->check()) {
            return redirect()->route('connexion')->with('error', 'Accès réservé aux pharmacies.');
        }
        return $next($request);
    }
}
