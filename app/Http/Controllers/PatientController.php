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

    public function findPharmacy(Request $request)
    {
        $patient = Auth::guard('patient')->user();

        // Get search parameters
        $searchZone = $request->input('zone');
        $searchMedicament = $request->input('medicament');

        // Build query for pharmacies
        $query = \App\Models\Pharmacie::with('zone')
            ->where('statut', 'valide'); // Only show validated pharmacies

        // Filter by zone if provided (don't default to patient zone anymore)
        if ($searchZone) {
            $query->whereHas('zone', function ($q) use ($searchZone) {
                $q->where('nom', 'like', '%' . $searchZone . '%')
                    ->orWhere('ville', 'like', '%' . $searchZone . '%');
            });
        }

        // Filter by medication if provided
        if ($searchMedicament) {
            $query->whereHas('medicaments', function ($q) use ($searchMedicament) {
                $q->where('nom', 'like', '%' . $searchMedicament . '%');
            });
        }

        $pharmacies = $query->get();

        // Calculate distance for each pharmacy if patient has zone with coordinates
        // or if pharmacy has coordinates
        $patientLat = null;
        $patientLng = null;

        // Try to get patient coordinates (we'll use a default for their zone)
        // For now, we'll calculate distance only if pharmacy has coordinates
        if ($patient && $patient->zone_id) {
            // Get first pharmacy in same zone to estimate patient location
            $samplePharmacy = \App\Models\Pharmacie::where('zone_id', $patient->zone_id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->first();

            if ($samplePharmacy) {
                $patientLat = $samplePharmacy->latitude;
                $patientLng = $samplePharmacy->longitude;
            }
        }

        // Add distance to each pharmacy
        $pharmacies = $pharmacies->map(function ($pharmacy) use ($patientLat, $patientLng) {
            if ($pharmacy->latitude && $pharmacy->longitude && $patientLat && $patientLng) {
                $pharmacy->distance = $this->calculateDistance(
                    $patientLat,
                    $patientLng,
                    $pharmacy->latitude,
                    $pharmacy->longitude
                );
            } else {
                $pharmacy->distance = null;
            }
            return $pharmacy;
        });

        // Sort by distance if available
        $pharmacies = $pharmacies->sortBy(function ($pharmacy) {
            return $pharmacy->distance ?? 999999; // Put pharmacies without distance at the end
        });

        return view('patient.find_pharmacy', [
            'pharmacies' => $pharmacies,
            'patient' => $patient,
            'patientLat' => $patientLat,
            'patientLng' => $patientLng,
            'searchQuery' => [
                'zone' => $searchZone,
                'medicament' => $searchMedicament
            ]
        ]);
    }

    /**
     * Calculate distance between two coordinates using Haversine formula
     * Returns distance in kilometers
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth's radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 2);
    }

    public function guideHospitals(Request $request)
    {
        $patient = Auth::guard('patient')->user();

        // Get specialty filter if provided
        $specialtyFilter = $request->input('specialite');

        // Build query for hospitals - show all by default
        $query = \App\Models\Hopital::with(['zone', 'medecins.specialite', 'specialites'])
            ->where('statut', 'verifie'); // Only show verified hospitals

        // Filter by specialty if provided
        if ($specialtyFilter) {
            $query->where(function ($q) use ($specialtyFilter) {
                // Filter by declared specialties
                $q->whereHas('specialites', function ($sub) use ($specialtyFilter) {
                    $sub->where('nom', 'like', '%' . $specialtyFilter . '%');
                })
                    // OR filter by affiliated doctors' specialties (as backup/alternative)
                    ->orWhereHas('medecins.specialite', function ($sub) use ($specialtyFilter) {
                        $sub->where('nom', 'like', '%' . $specialtyFilter . '%');
                    });
            });
        }

        $hospitals = $query->get();

        // Get unique specialties for the filter dropdown from Specialite table
        $specialties = \App\Models\Specialite::orderBy('nom')->pluck('nom');

        // Get patient coordinates for map centering (estimate from zone)
        $patientLat = null;
        $patientLng = null;

        if ($patient && $patient->zone_id) {
            // Try to get coordinates from a pharmacy in the same zone
            $sampleLocation = \App\Models\Pharmacie::where('zone_id', $patient->zone_id)
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->first();

            if ($sampleLocation) {
                $patientLat = $sampleLocation->latitude;
                $patientLng = $sampleLocation->longitude;
            }
        }

        return view('patient.guide_hospitals', [
            'hospitals' => $hospitals,
            'patient' => $patient,
            'patientLat' => $patientLat,
            'patientLng' => $patientLng,
            'specialties' => $specialties,
            'selectedSpecialty' => $specialtyFilter
        ]);
    }
}