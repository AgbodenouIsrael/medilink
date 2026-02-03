<?php

namespace App\Http\Controllers;

use App\Models\Pharmacie;
use App\Models\Zone;
use App\Models\Ordonnance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PharmacieController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::orderBy('ville')->orderBy('nom')->get();
        return view('pharmacie.auth.register', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_officine' => 'required|string|max:255',
            'pharmacien_titulaire' => 'required|string|max:255',
            'numero_licence' => 'required|string|max:50|unique:pharmacies',
            'adresse_complete' => 'required|string',
            'email' => 'required|string|email|max:255|unique:pharmacies',
            'telephone' => 'required|string|max:20',
            'zone_id' => 'required|exists:zones,id',

            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'privacy_policy' => 'accepted',
        ]);

        $pharmacie = Pharmacie::create([
            'nom_officine' => $request->nom_officine,
            'pharmacien_titulaire' => $request->pharmacien_titulaire,
            'numero_licence' => $request->numero_licence,
            'adresse_complete' => $request->adresse_complete,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'zone_id' => $request->zone_id,
            'password' => Hash::make($request->password),
            // Default values
            'accepte_ordonnances' => true,
            'en_ligne' => false,
            'statut' => 'en_attente',
        ]);

        Auth::guard('pharmacie')->login($pharmacie);

        return redirect()->route('pharmacie.pending');
    }

    public function pending()
    {
        return view('pharmacie_pending');
    }

    public function dashboard()
    {
        $pharmacie = Auth::guard('pharmacie')->user();

        if ($pharmacie->statut === 'en_attente') {
            return redirect()->route('pharmacie.pending');
        }

        if ($pharmacie->statut === 'rejete') {
            Auth::guard('pharmacie')->logout();
            return redirect()->route('connexion')->with('error', 'Votre compte a été rejeté. Contactez l\'administrateur.');
        }

        // Fetch metrics
        $medicaments = $pharmacie->medicaments;

        // Stock alerts
        $stockAlerts = $medicaments->filter(function ($m) {
            return $m->quantite <= $m->seuil_alerte;
        });

        // Expiring products (next 30 days)
        $expiringProducts = $medicaments->filter(function ($m) {
            return $m->date_expiration && \Carbon\Carbon::parse($m->date_expiration)->diffInDays(now()) < 30;
        });

        // Current daily sales (mock logic - needs specific Sales model interaction later)
        // For now we'll calculate based on a simplified logic or placeholder if no Sales model yet.
        // Assuming no Sales model yet, we will pass 0.
        $dailySales = 0;
        $prescriptions = Ordonnance::with(['patient', 'medecin'])->latest()->take(5)->get();

        return view('pharmacie.dashboard', compact('pharmacie', 'stockAlerts', 'expiringProducts', 'dailySales', 'prescriptions'));
    }

    public function inventory()
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        if ($pharmacie->statut !== 'valide')
            return redirect()->route('pharmacie.pending');

        $medicaments = $pharmacie->medicaments()->latest()->get();

        $totalProducts = $medicaments->count();
        $totalValue = $medicaments->sum(function ($m) {
            return $m->quantite * $m->prix_unitaire;
        });
        $stockAlerts = $medicaments->filter(function ($m) {
            return $m->quantite <= $m->seuil_alerte;
        })->count();
        $expiringProducts = $medicaments->filter(function ($m) {
            return $m->date_expiration && \Carbon\Carbon::parse($m->date_expiration)->diffInDays(now()) <= 30;
        })->count();

        return view('pharmacie.inventory.index', compact('medicaments', 'totalProducts', 'totalValue', 'stockAlerts', 'expiringProducts'));
    }

    public function createProduct()
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        if ($pharmacie->statut !== 'valide')
            return redirect()->route('pharmacie.pending');

        return view('pharmacie.inventory.create');
    }

    public function storeProduct(Request $request)
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        if ($pharmacie->statut !== 'valide')
            return redirect()->route('pharmacie.pending');

        $request->validate([
            'nom' => 'required|string|max:255',
            'dosage' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quantite' => 'required|integer|min:0',
            'prix_unitaire' => 'required|numeric|min:0',
            'date_expiration' => 'nullable|date|after:today',
            'seuil_alerte' => 'nullable|integer|min:0',
        ]);

        $pharmacie->medicaments()->create([
            'nom' => $request->nom,
            'dosage' => $request->dosage,
            'description' => $request->description,
            'quantite' => $request->quantite,
            'prix_unitaire' => $request->prix_unitaire,
            'date_expiration' => $request->date_expiration,
            'seuil_alerte' => $request->seuil_alerte ?? 10,
            'visible_public' => $request->has('visible_public'),
        ]);

        return redirect()->route('pharmacie.inventory')->with('success', 'Médicament ajouté avec succès.');
    }

    public function prescriptions()
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        if ($pharmacie->statut !== 'valide')
            return redirect()->route('pharmacie.pending');

        $ordonnances = Ordonnance::with(['patient', 'medecin'])->latest()->get();
        return view('pharmacie.prescriptions', compact('ordonnances'));
    }

    public function sales()
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        if ($pharmacie->statut !== 'valide')
            return redirect()->route('pharmacie.pending');

        $medicaments = $pharmacie->medicaments()->where('quantite', '>', 0)->get();
        return view('pharmacie.sales', compact('medicaments'));
    }

    public function profil()
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        return view('pharmacie.profile', compact('pharmacie'));
    }
}
