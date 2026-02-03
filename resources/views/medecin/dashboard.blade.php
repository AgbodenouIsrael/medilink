@extends('layouts.medecin')

@section('title', 'Dashboard Professionnel - Medilink')

@section('content')
    <header class="dashboard-header">
        <h2>Bienvenue Dr. {{ $medecin->prenom }} {{ $medecin->nom }}</h2>
    </header>

    <section class="dashboard-grid">

        <div class="stat-card">
            <i class="fas fa-user-injured icon-large"></i>
            <h3>Vos Patients</h3>
            <p>{{ $patientsCount }} patients suivis actuellement.</p>
            <a href="{{ route('mes_patients') }}" class="btn primary-btn small-btn">Voir la liste</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-envelope-open-text icon-large"></i>
            <h3>Messagerie</h3>
            <p>Chat en temps réel avec vos patients pour les suivis.</p>
            <a href="{{ route('messages_medecin') }}" class="btn primary-btn small-btn">Accéder au Chat</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-calendar-check icon-large"></i>
            <h3>Planification & Activité</h3>
            <p>Voir vos horaires et planifier de nouveaux rendez-vous.</p>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="btn primary-btn small-btn">Gérer les RDV</a>
        </div>

        <div class="stat-card">
            <i class="fas fa-cog icon-large"></i>
            <h3>Paramètres & Profil</h3>
            <p>Mettez à jour vos informations et votre certificat.</p>
            <a href="{{ route('profil_medecin') }}" class="btn primary-btn small-btn">Modifier le profil</a>
        </div>

    </section>
@endsection