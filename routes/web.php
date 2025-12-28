<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

//enregistrement patient
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

Route::get('/', function () {
    return view('index');
})->name('connexion');

// Pour afficher la page de connexion (si tu ne l'as pas déjà fait)
Route::get('/connexion', function () {
    return view('index'); // Remplace 'index' par le nom de ta vue de connexion
})->name('login');

// Pour traiter les données envoyées par le formulaire de connexion
Route::post('/connexion', [PatientController::class, 'login'])->name('login.submit');


Route::get('/dashboard_hopital', function () {
    return view('dashboard_hopital');
})->name('dashboard_hopital');


Route::get('/dashboard_medecin', function () {
    return view('dashboard_medecin');
})->name('dashboard_medecin');


Route::get('/dashboard_patient', function () {
    return view('dashboard_patient');
})->name('dashboard_patient');


Route::get('/guide_hopitaux', function () {
    return view('guide_hopitaux');
})->name('guide_hopitaux');


Route::get('/inscription_hopitaux', function () {
    return view('inscription_hopitaux');
})->name('inscription_hopitaux');


Route::get('/inscription_medecin', function () {
    return view('inscription_medecin');
})->name('inscription_medecin');


Route::get('/inscription_patient', function () {
    return view('inscription_patient');
})->name('inscription_patient');


Route::get('/liste_medecins_hopital', function () {
    return view('liste_medecins_hopital');
})->name('liste_medecins_hopital');


Route::get('/liste_patients_hopital', function () {
    return view('liste_patients_hopital');
})->name('liste_patients_hopital');


Route::get('/ma_fiche_medicale', function () {
    return view('ma_fiche_medicale');
})->name('ma_fiche_medicale');


Route::get('/mes_hopitaux_medecin', function () {
    return view('mes_hopitaux_medecin');
})->name('mes_hopitaux_medecin');


Route::get('/mes_messages', function () {
    return view('mes_messages');
})->name('mes_messages');


Route::get('/mes_patients', function () {
    return view('mes_patients');
})->name('mes_patients');


Route::get('/messages_medecin', function () {
    return view('messages_medecin');
})->name('messages_medecin');


Route::get('/profil_hopital', function () {
    return view('profil_hopital');
})->name('profil_hopital');


Route::get('/profil_medecin', function () {
    return view('profil_medecin');
})->name('profil_medecin');


Route::get('/profil', function () {
    return view('profil');
})->name('profil');


Route::get('/trouver_pharmacie', function () {
    return view('trouver_pharmacie');
})->name('trouver_pharmacie');
