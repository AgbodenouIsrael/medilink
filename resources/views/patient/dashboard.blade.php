@extends('layouts.patient')

@section('content')
    <header class="dashboard-header">
        <h2>
            @if(Auth::guard('patient')->check())
                Bienvenue, {{ Auth::guard('patient')->user()->prenom }} {{ Auth::guard('patient')->user()->nom }}
            @else
                Bienvenue, Patient (Non connecté)
            @endif
        </h2>
    </header>

    <section class="dashboard-grid">

        <div class="stat-card">
            <i class="fas fa-file-medical icon-large"></i>
            <h3>Dossier Médical</h3>
            <p>Consultez vos antécédents et traitements.</p>
            <a href="{{ route('ma_fiche_medicale') }}" class="btn primary-btn small-btn">Ma Fiche Médicale</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-id-card-alt icon-large"></i>
            <h3>Autorisations d'Accès</h3>
            <p>Gérez qui peut voir votre dossier médical.</p>
            <a href="{{ route('autorisations.index') }}" class="btn primary-btn small-btn">Gérer les accès</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-search-location icon-large"></i>
            <h3>Trouver une Pharmacie</h3>
            <p>Recherchez les pharmacies de votre zone par médicament.</p>
            <a href="{{ route('trouver_pharmacie') }}" class="btn primary-btn small-btn">Rechercher</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-inbox icon-large"></i>
            <h3>Mes Messages</h3>
            <p>Discutez en temps réel avec vos médecins.</p>
            <a href="{{ route('mes_messages') }}" class="btn primary-btn small-btn">Voir les messages</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-map-marked-alt icon-large"></i>
            <h3>Guide des Hôpitaux</h3>
            <p>Trouvez un centre de santé et demandez un rendez-vous.</p>
            <a href="{{ route('guide_hopitaux') }}" class="btn primary-btn small-btn">Voir la carte</a>
        </div>

    </section>
@endsection