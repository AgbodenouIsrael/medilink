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
        <h3 style="margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-history" style="color: var(--color-admin);"></i>
            Dernières Activités de la Plateforme
        </h3>

        <div class="timeline-container"
            style="background: white; padding: 30px; border-radius: 12px; shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative;">
            <style>
                .timeline-container::before {
                    content: '';
                    position: absolute;
                    left: 45px;
                    top: 30px;
                    bottom: 30px;
                    width: 2px;
                    background: #f0f0f0;
                }

                .activity-item {
                    position: relative;
                    padding-left: 60px;
                    margin-bottom: 25px;
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                }

                .activity-item:last-child {
                    margin-bottom: 0;
                }

                .activity-icon-wrapper {
                    position: absolute;
                    left: 20px;
                    top: 0;
                    width: 40px;
                    height: 40px;
                    background: white;
                    border: 2px solid #f0f0f0;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 1;
                    transition: all 0.3s ease;
                }

                .activity-item:hover .activity-icon-wrapper {
                    border-color: var(--color-admin);
                    transform: scale(1.1);
                    box-shadow: 0 0 10px rgba(188, 51, 64, 0.1);
                }

                .activity-content {
                    background: #f9f9f9;
                    padding: 15px 20px;
                    border-radius: 8px;
                    border: 1px solid #eee;
                    transition: all 0.3s ease;
                }

                .activity-item:hover .activity-content {
                    background: white;
                    border-color: #ddd;
                    transform: translateX(5px);
                    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.02);
                }

                .activity-type {
                    font-size: 0.75em;
                    text-transform: uppercase;
                    font-weight: bold;
                    color: var(--color-admin);
                    margin-bottom: 5px;
                    display: block;
                }

                .activity-desc {
                    color: #333;
                    font-weight: 500;
                }

                .activity-time {
                    font-size: 0.8em;
                    color: #999;
                    margin-top: 5px;
                }
            </style>

            @forelse($activities as $activity)
                <div class="activity-item">
                    <div class="activity-icon-wrapper">
                        <i class="{{ $activity->icon }}" style="color: var(--color-admin); font-size: 1.1em;"></i>
                    </div>
                    <div class="activity-content">
                        <span class="activity-type">{{ $activity->type }}</span>
                        <div class="activity-desc">{{ $activity->description }}</div>
                        <div class="activity-time">
                            <i class="far fa-clock"></i> {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: #999; padding: 20px;">
                    <i class="fas fa-inbox" style="font-size: 2em; margin-bottom: 10px; display: block; opacity: 0.5;"></i>
                    Aucune activité récente sur la plateforme.
                </div>
            @endforelse
        </div>
    </section>
@endsection