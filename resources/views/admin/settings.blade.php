@extends('layouts.admin')

@section('title', 'Paramètres Plateforme - Admin')

@section('styles')
    <style>
        .settings-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }

        .settings-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #eee;
        }

        .settings-card h3 {
            color: var(--color-admin);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2em;
            border-bottom: 1px solid #f5f5f5;
            padding-bottom: 10px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px dashed #eee;
        }

        .stat-item:last-child {
            border-bottom: none;
        }

        .stat-label {
            color: #666;
            font-weight: 500;
        }

        .stat-value {
            font-weight: bold;
            color: #333;
        }

        .status-badge {
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            font-weight: 600;
        }

        .info-highlight {
            background: #fdf2f2;
            border-left: 4px solid var(--color-admin);
            padding: 15px;
            margin-top: 15px;
            border-radius: 4px;
            font-size: 0.9em;
            color: #555;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Paramètres de la Plateforme</h2>
        <p>Vue d'ensemble technique et statistiques globales du système.</p>
    </header>

    <div class="settings-container">
        <!-- System Info -->
        <div class="settings-card">
            <h3><i class="fas fa-server"></i> État du Système</h3>
            <div class="stat-item">
                <span class="stat-label">Statut du Serveur</span>
                <span class="status-badge">En ligne</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Version PHP</span>
                <span class="stat-value">{{ $stats['php_version'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Version Laravel</span>
                <span class="stat-value">{{ $stats['laravel_version'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Taille de la Base</span>
                <span class="stat-value">{{ $stats['db_size'] }}</span>
            </div>
        </div>

        <!-- Global Stats -->
        <div class="settings-card">
            <h3><i class="fas fa-chart-pie"></i> Statistiques Globales</h3>
            <div class="stat-item">
                <span class="stat-label">Total Utilisateurs</span>
                <span class="stat-value">{{ $stats['total_users'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Médecins</span>
                <span class="stat-value">{{ $stats['medecins'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Patients</span>
                <span class="stat-value">{{ $stats['patients'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Hôpitaux</span>
                <span class="stat-value">{{ $stats['hopitaux'] }}</span>
            </div>
            <div class="stat-item">
                <span class="stat-label">Pharmacies</span>
                <span class="stat-value">{{ $stats['pharmacies'] }}</span>
            </div>
        </div>

        <!-- Maintenance & Security -->
        <div class="settings-card">
            <h3><i class="fas fa-shield-alt"></i> Sécurité & Maintenance</h3>
            <p>Ces options sont verrouillées pour la démonstration.</p>
            <div class="info-highlight">
                <i class="fas fa-info-circle"></i> Le mode maintenance permet de suspendre l'accès public pour des mises à
                jour majeures.
            </div>
            <button class="btn primary-btn" disabled
                style="width: 100%; margin-top: 20px; background: #ccc; cursor: not-allowed;">
                Activer le Mode Maintenance
            </button>
        </div>
    </div>
@endsection