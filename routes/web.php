<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\HopitalController;
use App\Http\Controllers\PharmacieController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AutorisationController;
use App\Mail\MonEmailDeTest;
use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Route;

// ============================================
// ROUTES PUBLIQUES
// ============================================

// Page d'accueil / connexion
Route::get('/', function () {
    return view('index');
})->name('connexion');

// Authentification patient
Route::post('/connexion', [AuthController::class, 'login'])->name('login.submit');

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
Route::get('/inscription_medecin', [MedecinController::class, 'create'])->name('inscription_medecin');

Route::post('/inscription/medecin', [MedecinController::class, 'store'])->name('medecin.store');

// Inscription hôpital
Route::get('/inscription_hopitaux', [HopitalController::class, 'create'])->name('inscription_hopitaux');

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
    // Espace Patient - Chat
    Route::get('/mes_messages', [App\Http\Controllers\PatientChatController::class, 'index'])->name('mes_messages');
    Route::get('/mes_messages/{id}', [App\Http\Controllers\PatientChatController::class, 'show'])->name('mes_messages.show');
    Route::post('/mes_messages/{id}', [App\Http\Controllers\PatientChatController::class, 'store'])->name('patient.messages.store'); // Nouvelle route nommée

    // Autorisations
    Route::get('/autorisations', [App\Http\Controllers\AutorisationController::class, 'index'])->name('autorisations.index');
    Route::put('/autorisations/{id}', [App\Http\Controllers\AutorisationController::class, 'update'])->name('autorisations.update');
    Route::delete('/autorisations/{id}', [App\Http\Controllers\AutorisationController::class, 'destroy'])->name('autorisations.destroy');

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
    Route::post('/logout/patient', [AuthController::class, 'logout'])->name('logout.patient');
});

// ============================================
// ROUTES PROTÉGÉES - MÉDECIN
// ============================================
Route::middleware(['auth.medecin'])->group(function () {
    // Dashboard médecin
    Route::get('/dashboard_medecin', [MedecinController::class, 'dashboard'])->name('dashboard_medecin');

    // Page d'attente validation
    Route::get('/medecin/pending', [MedecinController::class, 'pending'])->name('medecin.pending');

    // Patients du médecin
    Route::get('/mes_patients', [MedecinController::class, 'mesPatients'])->name('mes_patients');
    Route::get('/patient/{id}', [MedecinController::class, 'showPatient'])->name('medecin.patient.show');
    Route::post('/patient/{id}/consultation', [MedecinController::class, 'storeConsultation'])->name('medecin.consultation.store');

    // Demande d'accès
    Route::get('/demande_acces', function () {
        return view('demande_acces');
    })->name('demande_acces');
    Route::post('/autorisations', [App\Http\Controllers\AutorisationController::class, 'store'])->name('autorisations.store');

    // Messages médecin
    Route::get('/messages_medecin', [App\Http\Controllers\MedecinChatController::class, 'index'])->name('messages_medecin');
    Route::get('/messages_medecin/{id}', [App\Http\Controllers\MedecinChatController::class, 'show'])->name('messages_medecin.show');
    Route::post('/messages_medecin/{id}', [App\Http\Controllers\MedecinChatController::class, 'store'])->name('medecin.messages.store'); // Route distincte

    // Hôpitaux du médecin
    Route::get('/mes_hopitaux_medecin', [MedecinController::class, 'mesHopitaux'])->name('mes_hopitaux_medecin');
    Route::post('/hopitaux/join', [MedecinController::class, 'joinHopital'])->name('hopitaux.join');

    // Profil médecin
    Route::get('/profil_medecin', [MedecinController::class, 'profil'])->name('profil_medecin');

    // Logout médecin
    Route::post('/logout/medecin', [AuthController::class, 'logout'])->name('logout.medecin');
});

// ============================================
// ROUTES PROTÉGÉES - HÔPITAL
// ============================================
Route::middleware(['auth.hopital'])->group(function () {
    // Dashboard hôpital
    Route::get('/dashboard_hopital', [HopitalController::class, 'dashboard'])->name('dashboard_hopital');

    // Page d'attente
    Route::get('/hopital/pending', [HopitalController::class, 'pending'])->name('hopital.pending');

    // Patients traités
    Route::get('/liste_patients_hopital', [HopitalController::class, 'patients'])->name('liste_patients_hopital');

    // Médecins de l'hôpital
    Route::get('/liste_medecins_hopital', [HopitalController::class, 'medecins'])->name('liste_medecins_hopital');

    // Profil hôpital
    Route::get('/profil_hopital', [HopitalController::class, 'profil'])->name('profil_hopital');

    // Gestion des médecins
    Route::post('/hopital/medecin/{id}/approve', [HopitalController::class, 'approveMedecin'])->name('hopital.medecin.approve');
    Route::post('/hopital/medecin/{id}/reject', [HopitalController::class, 'rejectMedecin'])->name('hopital.medecin.reject');

    // Logout hôpital
    Route::post('/logout/hopital', [AuthController::class, 'logout'])->name('logout.hopital');
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
    Route::post('/logout/pharmacie', [AuthController::class, 'logout'])->name('logout.pharmacie');
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

// ============================================
// ROUTES PROTÉGÉES - ADMIN
// ============================================
// ============================================
// ROUTES ADMIN LOGIN
// ============================================
Route::get('/admin/login', [App\Http\Controllers\AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [App\Http\Controllers\AdminController::class, 'logout'])->name('admin.logout');

// ============================================
// ROUTES PROTÉGÉES - ADMIN
// ============================================
Route::middleware(['auth.admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/validations', [App\Http\Controllers\AdminController::class, 'validations'])->name('admin.validations');
    Route::post('/admin/approve', [App\Http\Controllers\AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/admin/reject', [App\Http\Controllers\AdminController::class, 'reject'])->name('admin.reject');
});

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

Route::get('/test-email', function () {
    try {
        Mail::to('votre-email-de-test@gmail.com')->send(new MonEmailDeTest());
        return "Email envoyé avec succès !";
    } catch (\Exception $e) {
        return "Erreur : " . $e->getMessage();
    }
});