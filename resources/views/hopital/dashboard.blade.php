@extends('layouts.hopital')

@section('title', 'Dashboard Hôpital - Medilink')

@section('content')
    <header class="dashboard-header">
        <h2>Bienvenue, {{ $hopital->nom }}</h2>
    </header>

    <section class="dashboard-grid">

        <div class="stat-card">
            <i class="fas fa-history icon-large"></i>
            <h3>Historique des Patients</h3>
            <p>Liste des patients ayant été traités dans votre établissement.</p>
            <a href="{{ route('liste_patients_hopital') }}" class="btn primary-btn small-btn">Voir l'historique</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-user-tie icon-large"></i>
            <h3>Personnel Médical</h3>
            <p>Liste et heures d'activité des médecins exerçant ici.</p>
            <a href="{{ route('liste_medecins_hopital') }}" class="btn primary-btn small-btn">Gérer les Médecins</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-cog icon-large"></i>
            <h3>Paramètres & Profil</h3>
            <p>Mettez à jour les informations de l'hôpital et les coordonnées.</p>
            <a href="{{ route('profil_hopital') }}" class="btn primary-btn small-btn">Modifier le profil</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-procedures icon-large"></i>
            <h3>Admissions en Cours</h3>
            <p>Statistiques et gestion des patients actuellement hospitalisés.</p>
            <a href="#"
                onclick="alert('Cette fonctionnalité sera disponible prochainement. Elle permettra de gérer les admissions et hospitalisations en temps réel.'); return false;"
                class="btn primary-btn small-btn">Voir les Admissions</a>
        </div>

    </section>
@endsection