<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Medecin;
use App\Models\Hopital;
use App\Models\Pharmacie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountApproved;

class AdminController extends Controller
{
    // Login View
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    // Login Logic
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Les identifiants ne correspondent pas.',
        ]);
    }

    // Logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('admin.login');
    }

    // Dashboard Stats
    // Dashboard Stats
    public function index()
    {
        $stats = [
            'medecins' => Medecin::count(),
            'patients' => \App\Models\Patient::count(),
            'hopitaux' => Hopital::count(),
            'pharmacies' => Pharmacie::count(),
            'pending' => Medecin::where('statut', 'en_attente')->count() + Hopital::where('statut', 'en_attente')->count() + Pharmacie::where('statut', 'en_attente')->count(),
            'latest_medecin' => Medecin::latest()->first(),
        ];

        // Fetch latest 5 from each category
        $medecins = Medecin::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Médecin';
            $item->icon = 'fas fa-user-md';
            $item->description = 'Nouveau Médecin inscrit : ' . $item->prenom . ' ' . $item->nom . ' (' . $item->specialite . ')';
            return $item;
        });

        $hopitaux = Hopital::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Hôpital';
            $item->icon = 'fas fa-hospital-alt';
            $item->description = 'Nouvel Hôpital inscrit : ' . $item->nom;
            return $item;
        });

        $pharmacies = Pharmacie::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Pharmacie';
            $item->icon = 'fas fa-pills';
            $item->description = 'Nouvelle Pharmacie inscrite : ' . $item->nom_officine;
            return $item;
        });

        $patients = \App\Models\Patient::latest()->take(5)->get()->map(function ($item) {
            $item->type = 'Patient';
            $item->icon = 'fas fa-user-injured';
            $item->description = 'Nouveau Patient inscrit : ' . $item->prenom . ' ' . $item->nom;
            return $item;
        });

        // Merge and sort
        $activities = $medecins->concat($hopitaux)->concat($pharmacies)->concat($patients);

        $activities = $activities->sortByDesc('created_at')->take(10);

        $pending_count = $stats['pending'];

        return view('admin.dashboard', compact('stats', 'activities', 'pending_count'));
    }

    // List Pending Validations
    public function validations()
    {
        $pendingMedecins = Medecin::where('statut', 'en_attente')->get();
        $pendingHopitaux = Hopital::where('statut', 'en_attente')->get();
        $pendingPharmacies = Pharmacie::where('statut', 'en_attente')->get();

        $pending_count = $pendingMedecins->count() + $pendingHopitaux->count() + $pendingPharmacies->count();

        return view('admin.validation', compact('pendingMedecins', 'pendingHopitaux', 'pendingPharmacies', 'pending_count'));
    }

    // Comprehensive Entities Directory
    public function entities()
    {
        $medecins = Medecin::all();
        $hopitaux = Hopital::all();
        $pharmacies = Pharmacie::all();

        $pending_count = Medecin::where('statut', 'en_attente')->count() +
            Hopital::where('statut', 'en_attente')->count() +
            Pharmacie::where('statut', 'en_attente')->count();

        return view('admin.entities', compact('medecins', 'hopitaux', 'pharmacies', 'pending_count'));
    }

    // Approve Entity
    public function approve(Request $request)
    {
        $request->validate([
            'type' => 'required|in:medecin,hopital,pharmacie',
            'id' => 'required|integer'
        ]);

        if ($request->type === 'medecin') {
            $entity = Medecin::findOrFail($request->id);
            $entity->update(['statut' => 'actif']);
            try {
                Mail::to($entity->email)->send(new AccountApproved($entity));
            } catch (\Exception $e) {
                return back()->with('warning', 'Compte medecin activé, mais échec de l\'envoi du mail: ' . $e->getMessage());
            }
        } elseif ($request->type === 'hopital') {
            $entity = Hopital::findOrFail($request->id);
            $entity->update(['statut' => 'verifie']);
            try {
                Mail::to($entity->email)->send(new AccountApproved($entity));
            } catch (\Exception $e) {
                return back()->with('warning', 'Compte hôpital validé, mais échec de l\'envoi du mail: ' . $e->getMessage());
            }
        } elseif ($request->type === 'pharmacie') {
            $entity = Pharmacie::findOrFail($request->id);
            $entity->update(['statut' => 'valide']);
            try {
                Mail::to($entity->email)->send(new AccountApproved($entity));
            } catch (\Exception $e) {
                return back()->with('warning', 'Compte pharmacie validé, mais échec de l\'envoi du mail: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Compte validé avec succès.');
    }

    // Reject (Delete) Entity
    public function reject(Request $request)
    {
        $request->validate([
            'type' => 'required|in:medecin,hopital,pharmacie',
            'id' => 'required|integer',
            'reason' => 'nullable|string'
        ]);

        if ($request->type === 'medecin') {
            $entity = Medecin::findOrFail($request->id);
            if ($entity->certificat_path) {
                Storage::disk('public')->delete($entity->certificat_path);
            }
            $entity->delete();
        } elseif ($request->type === 'hopital') {
            $entity = Hopital::findOrFail($request->id);
            if ($entity->fichier_enregistrement_path) {
                Storage::disk('public')->delete($entity->fichier_enregistrement_path);
            }
            $entity->delete();
        } elseif ($request->type === 'pharmacie') {
            $entity = Pharmacie::findOrFail($request->id);
            $entity->delete();
        }

        return back()->with('success', 'Compte rejeté et données supprimées.');
    }

    // Platform Settings
    public function settings()
    {
        $stats = [
            'medecins' => Medecin::count(),
            'patients' => \App\Models\Patient::count(),
            'hopitaux' => Hopital::count(),
            'pharmacies' => Pharmacie::count(),
            'total_users' => Medecin::count() + \App\Models\Patient::count() + Hopital::count() + Pharmacie::count(),
            'db_size' => 'N/A',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
        ];

        $pending_count = Medecin::where('statut', 'en_attente')->count() +
            Hopital::where('statut', 'en_attente')->count() +
            Pharmacie::where('statut', 'en_attente')->count();

        return view('admin.settings', compact('stats', 'pending_count'));
    }
}
