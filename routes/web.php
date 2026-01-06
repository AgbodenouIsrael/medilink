<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\HopitalController;
use App\Http\Controllers\PharmacieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DossierMedicalController;

// ============================================
// ROUTES PUBLIQUES
// ============================================

// Page d'accueil / connexion
Route::get('/', function () {
    return view('index');
})->name('connexion');

// Authentification patient
Route::post('/connexion', [PatientController::class, 'login'])->name('login.submit');

// Inscription patient
Route::get('/inscription_patient', function () {
    return view('inscription_patient');
})->name('inscription_patient');

Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

// Routes pour le dossier médical
Route::middleware(['auth.patient'])->group(function () {
    // Afficher le dossier médical
    Route::get('/ma_fiche_medicale', [DossierMedicalController::class, 'index'])->name('ma_fiche_medicale');
    
    // Antécédents
    Route::post('/antecedents', [DossierMedicalController::class, 'storeAntecedent'])->name('antecedent.store');
    Route::put('/antecedents/{id}', [DossierMedicalController::class, 'updateAntecedent'])->name('antecedent.update');
    Route::delete('/antecedents/{id}', [DossierMedicalController::class, 'destroyAntecedent'])->name('antecedent.destroy');
    
    // Allergies
    Route::post('/allergies', [DossierMedicalController::class, 'storeAllergie'])->name('allergie.store');
    Route::delete('/allergies/{id}', [DossierMedicalController::class, 'destroyAllergie'])->name('allergie.destroy');
    
    // Documents
    Route::post('/documents', [DossierMedicalController::class, 'storeDocument'])->name('document.store');
    Route::delete('/documents/{id}', [DossierMedicalController::class, 'destroyDocument'])->name('document.destroy');
});

// Inscription médecin
Route::get('/inscription_medecin', function () {
    return view('inscription_medecin');
})->name('inscription_medecin');

Route::post('/inscription/medecin', [MedecinController::class, 'store'])->name('medecin.store');

// Inscription hôpital
Route::get('/inscription_hopitaux', function () {
    return view('inscription_hopitaux');
})->name('inscription_hopitaux');

Route::post('/inscription/hopital', [HopitalController::class, 'store'])->name('hopital.store');

// Inscription pharmacie
Route::get('/inscription_pharmacie', function () {
    return view('inscription_pharmacie');
})->name('inscription_pharmacie');

Route::post('/inscription/pharmacie', [PharmacieController::class, 'store'])->name('pharmacie.store');

// ============================================
// ROUTES PROTÉGÉES - PATIENT
// ============================================
Route::middleware(['auth.patient'])->group(function () {
    // Dashboard patient
    Route::get('/dashboard_patient', function () {
        return view('dashboard_patient');
    })->name('dashboard_patient');
    // Dans le groupe middleware patient
Route::put('/profil/update', [PatientController::class, 'update'])->name('patient.update');
    
    // Fiche médicale du patient
Route::get('/ma_fiche_medicale', function () {
    $patient = Auth::guard('patient')->user();
    
    return view('ma_fiche_medicale', [
        'patient' => $patient,
        'antecedents' => $patient->antecedents ?? collect(),
        'allergies' => $patient->allergies ?? collect(),
        'ordonnances' => $patient->ordonnances ?? collect(),
        'documents' => $patient->documents_medicaux ?? collect(),
    ]);
})->name('ma_fiche_medicale')->middleware('auth.patient');
    
    // Trouver pharmacie
    Route::get('/trouver_pharmacie', function () {
        return view('trouver_pharmacie');
    })->name('trouver_pharmacie');
    
    // Messages
    Route::get('/mes_messages', function () {
        return view('mes_messages');
    })->name('mes_messages');
    
    // Guide hôpitaux
    Route::get('/guide_hopitaux', function () {
        return view('guide_hopitaux');
    })->name('guide_hopitaux');
    
    // Profil patient
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
    
    // Mettre à jour le profil
    Route::put('/profil/update', [PatientController::class, 'update'])->name('patient.update');
    
    // Logout patient
    Route::post('/logout/patient', function () {
        Auth::guard('patient')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('connexion')->with('success', 'Vous êtes déconnecté.');
    })->name('logout.patient');
});

// ============================================
// ROUTES PROTÉGÉES - MÉDECIN
// ============================================
Route::middleware(['auth.medecin'])->group(function () {
    // Dashboard médecin
    Route::get('/dashboard_medecin', function () {
        return view('dashboard_medecin');
    })->name('dashboard_medecin');
    
    // Patients du médecin
    Route::get('/mes_patients', function () {
        return view('mes_patients');
    })->name('mes_patients');
    
    // Messages médecin
    Route::get('/messages_medecin', function () {
        return view('messages_medecin');
    })->name('messages_medecin');
    
    // Hôpitaux du médecin
    Route::get('/mes_hopitaux_medecin', function () {
        return view('mes_hopitaux_medecin');
    })->name('mes_hopitaux_medecin');
    
    // Profil médecin
    Route::get('/profil_medecin', function () {
        return view('profil_medecin');
    })->name('profil_medecin');
    
    // Logout médecin
    Route::post('/logout/medecin', function () {
        Auth::guard('medecin')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('connexion')->with('success', 'Vous êtes déconnecté.');
    })->name('logout.medecin');
});

// ============================================
// ROUTES PROTÉGÉES - HÔPITAL
// ============================================
Route::middleware(['auth.hopital'])->group(function () {
    // Dashboard hôpital
    Route::get('/dashboard_hopital', function () {
        return view('dashboard_hopital');
    })->name('dashboard_hopital');
    
    // Patients traités
    Route::get('/liste_patients_hopital', function () {
        return view('liste_patients_hopital');
    })->name('liste_patients_hopital');
    
    // Médecins de l'hôpital
    Route::get('/liste_medecins_hopital', function () {
        return view('liste_medecins_hopital');
    })->name('liste_medecins_hopital');
    
    // Profil hôpital
    Route::get('/profil_hopital', function () {
        return view('profil_hopital');
    })->name('profil_hopital');
    
    // Logout hôpital
    Route::post('/logout/hopital', function () {
        Auth::guard('hopital')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('connexion')->with('success', 'Vous êtes déconnecté.');
    })->name('logout.hopital');
});

// ============================================
// ROUTES PROTÉGÉES - PHARMACIE
// ============================================
Route::middleware(['auth.pharmacie'])->group(function () {
    // Dashboard pharmacie
    Route::get('/dashboard_pharmacie', function () {
        return view('dashboard_pharmacie');
    })->name('dashboard_pharmacie');
    
    // Prescriptions
    Route::get('/pharmacie_prescription', function () {
        return view('pharmacie_prescription');
    })->name('pharmacie_prescription');
    
    // Inventaire
    Route::get('/pharmacie_inventory', function () {
        return view('pharmacie_inventory');
    })->name('pharmacie_inventory');
    
    // Ventes
    Route::get('/pharmacie_sales', function () {
        return view('pharmacie_sales');
    })->name('pharmacie_sales');
    
    // Ajouter produit
    Route::get('/pharmacie_add_product', function () {
        return view('pharmacie_add_product');
    })->name('pharmacie_add_product');
    
    // Profil pharmacie
    Route::get('/pharmacie_profil', function () {
        return view('pharmacie_profil');
    })->name('pharmacie_profil');
    
    // Logout pharmacie
    Route::post('/logout/pharmacie', function () {
        Auth::guard('pharmacie')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('connexion')->with('success', 'Vous êtes déconnecté.');
    })->name('logout.pharmacie');
});

// ============================================
// ROUTES POUR TESTS (À SUPPRIMER EN PRODUCTION)
// ============================================
Route::middleware(['auth.patient'])->group(function () {
    Route::get('/test-patient', function () {
        $user = Auth::guard('patient')->user();
        return "Test patient réussi!<br>ID: {$user->id}<br>Nom: {$user->prenom} {$user->nom}<br>Email: {$user->email}";
    });
});

Route::middleware(['auth.medecin'])->group(function () {
    Route::get('/test-medecin', function () {
        return "Test médecin réussi!";
    });
});

Route::middleware(['auth.hopital'])->group(function () {
    Route::get('/test-hopital', function () {
        return "Test hôpital réussi!";
    });
});

Route::middleware(['auth.pharmacie'])->group(function () {
    Route::get('/test-pharmacie', function () {
        return "Test pharmacie réussi!";
    });
});

// ============================================
// ROUTE DE DÉPANNAGE (facultative)
// ============================================
Route::get('/debug-session', function () {
    echo "<h1>Debug Session</h1>";
    echo "<pre>";
    echo "Session ID: " . session()->getId() . "\n";
    echo "All Session Data:\n";
    print_r(session()->all());
    echo "\nAuth guards:\n";
    echo "Patient: " . (Auth::guard('patient')->check() ? 'Connecté' : 'Non connecté') . "\n";
    echo "Médecin: " . (Auth::guard('medecin')->check() ? 'Connecté' : 'Non connecté') . "\n";
    echo "Hôpital: " . (Auth::guard('hopital')->check() ? 'Connecté' : 'Non connecté') . "\n";
    echo "Pharmacie: " . (Auth::guard('pharmacie')->check() ? 'Connecté' : 'Non connecté') . "\n";
    echo "</pre>";
});