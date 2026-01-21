<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMedicalAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Si c'est un patient qui accède à ses propres données
        if (auth()->guard('patient')->check()) {
            return $next($request);
        }

        // Si c'est un médecin
        if (auth()->guard('medecin')->check()) {
            // Récupérer l'ID patient de la route (ex: /patient/{id}/dossier)
            $patientId = $request->route('id') ?? $request->input('patient_id'); // Ajuster selon route

            if (!$patientId) {
                // Si pas d'ID patient, on laisse passer (peut-être une page de liste)
                return $next($request);
            }

            $hasAccess = \App\Models\Autorisation::where('medecin_id', $user->id)
                ->where('patient_id', $patientId)
                ->where('statut', 'approuve')
                ->exists();

            if ($hasAccess) {
                return $next($request);
            }
        }

        // Si admin ou urgence (à implémenter)
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }

        return redirect()->route('dashboard_medecin')->with('error', 'Accès non autorisé à ce dossier patient.');
    }
}
