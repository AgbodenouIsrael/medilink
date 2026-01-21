<?php

namespace App\Http\Controllers;

use App\Models\Autorisation;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AutorisationController extends Controller
{
    // Liste des demandes pour le patient connecté
    public function index()
    {
        $patient = Auth::guard('patient')->user();
        $autorisations = $patient->autorisations()->with(['medecin', 'hopital'])->latest()->get();
        return view('autorisations.index', compact('autorisations'));
    }

    // Demande d'accès par un médecin ou un hôpital
    public function store(Request $request)
    {
        $request->validate([
            'patient_email' => 'required|email|exists:patients,email',
            'type_acces' => 'required|in:lecture,ecriture,complet',
            'motif' => 'required|string|max:255',
        ]);

        $requester = null;
        $column = null;

        if (Auth::guard('medecin')->check()) {
            $requester = Auth::guard('medecin')->user();
            $column = 'medecin_id';
        } elseif (Auth::guard('hopital')->check()) {
            $requester = Auth::guard('hopital')->user();
            $column = 'hopital_id';
        } else {
            abort(403, 'Accès non autorisé');
        }

        $patient = Patient::where('email', $request->patient_email)->first();

        // Vérifier si une demande existe déjà
        $existing = Autorisation::where($column, $requester->id)
            ->where('patient_id', $patient->id)
            ->whereIn('statut', ['en_attente', 'approuve'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Une demande est déjà en cours ou approuvée.');
        }

        Autorisation::create([
            'patient_id' => $patient->id,
            $column => $requester->id,
            'type_acces' => $request->type_acces,
            'statut' => 'en_attente',
            'motif' => $request->motif,
            'date_debut' => now(), // Début immédiat à la création
            'created_by_id' => $requester->id,
            'created_by_type' => get_class($requester),
        ]);

        return back()->with('success', 'Demande d\'accès envoyée au patient.');
    }

    // Réponse du patient (Approuver/Refuser)
    public function update(Request $request, $id)
    {
        $autorisation = Autorisation::findOrFail($id);

        // Sécurité : seul le patient concerné peut modifier
        if ($autorisation->patient_id !== Auth::guard('patient')->id()) {
            abort(403);
        }

        $request->validate(['statut' => 'required|in:approuve,refuse']);

        $autorisation->update([
            'statut' => $request->statut,
            'date_fin' => $request->statut === 'approuve' ? now()->addMonths(1) : null, // Par défaut 1 mois
        ]);

        return back()->with('success', 'Autorisation mise à jour.');
    }

    // Révocation
    public function destroy($id)
    {
        $autorisation = Autorisation::findOrFail($id);

        if ($autorisation->patient_id !== Auth::guard('patient')->id()) {
            abort(403);
        }

        $autorisation->update(['statut' => 'revoke']);

        return back()->with('success', 'Accès révoqué.');
    }
}
