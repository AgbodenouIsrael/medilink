@extends('layouts.admin')

@section('title', 'Admin - Medilink')

@section('content')
    <header class="dashboard-header">
        <h2>Administration Générale</h2>
        <p>Supervision de la plateforme et gestion des nouveaux inscrits.</p>
    </header>

    <div class="dashboard-grid">
        <div class="stat-card">
            <i class="fas fa-user-md icon-large"></i>
            <h3>{{ $stats['medecins'] ?? 0 }}</h3>
            <p>Médecins Inscrits</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-user-injured icon-large"></i>
            <h3>{{ $stats['patients'] ?? 0 }}</h3>
            <p>Patients Actifs</p>
        </div>

        <div class="stat-card">
            <i class="fas fa-hospital icon-large"></i>
            <h3>{{ $stats['hopitaux'] ?? 0 }}</h3>
            <p>Hôpitaux Partenaires</p>
        </div>

        <div class="stat-card" style="border: 2px solid var(--color-admin);">
            <i class="fas fa-exclamation-circle icon-large"></i>
            <h3>{{ $stats['pending'] ?? 0 }}</h3>
            <p>Comptes en Attente</p>
            <a href="{{ route('admin.validations') }}" class="btn small-btn primary-btn"
                style="background-color: var(--color-admin);">Examiner</a>
        </div>
    </div>

    <section style="margin-top: 40px;">
        <h3>Dernières Activités de la Plateforme</h3>
        <div class="settings-card" style="margin-top: 20px;">
            <ul class="action-list">
                @forelse($activities as $activity)
                    <li>
                        <a href="#">
                            <i class="{{ $activity->icon }}"></i> {{ $activity->description }}
                            <span
                                style="margin-left:auto; font-size:0.8em; color:#888;">{{ $activity->created_at->diffForHumans() }}</span>
                        </a>
                    </li>
                @empty
                    <li>
                        <a href="#">
                            <i class="fas fa-info-circle"></i> Aucune activité récente.
                        </a>
                    </li>
                @endforelse
            </ul>
        </div>
    </section>
@endsection