@extends('layouts.patient')

@section('title', 'Mes Autorisations - MediLink')

@section('styles')
    <style>
        .auth-section {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .auth-header {
            padding: 20px;
            border-bottom: 2px solid #e9ecef;
            margin-bottom: 20px;
        }

        .auth-header.pending {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
        }

        .auth-header.active {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
        }

        .auth-item {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .auth-item:last-child {
            border-bottom: none;
        }

        .auth-info {
            flex: 1;
        }

        .auth-info .name {
            font-size: 1.1em;
            font-weight: 600;
            color: #3498db;
            margin-bottom: 5px;
        }

        .auth-info .detail {
            font-size: 0.9em;
            color: #666;
            margin: 3px 0;
        }

        .auth-actions {
            display: flex;
            gap: 10px;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-approve:hover {
            background-color: #218838;
        }

        .btn-reject {
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9em;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-reject:hover {
            background-color: #c82333;
        }

        .btn-revoke {
            background-color: #6c757d;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 0.9em;
        }

        .btn-revoke:hover {
            background-color: #5a6268;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
            font-style: italic;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Gestion des Accès Médicaux</h2>
        <p>Gérez les autorisations d'accès à votre dossier médical</p>
    </header>

    {{-- Messages Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
        </div>
    @endif

    {{-- Demandes en attente --}}
    <div class="auth-section">
        <div class="auth-header pending">
            <h3><i class="fas fa-clock"></i> Demandes en attente</h3>
            <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9em;">Médecins demandant l'accès à votre dossier.</p>
        </div>
        @forelse($autorisations->where('statut', 'en_attente') as $auth)
            <div class="auth-item">
                <div class="auth-info">
                    <div class="name">
                        Dr. {{ $auth->medecin->prenom }} {{ $auth->medecin->nom }}
                    </div>
                    <div class="detail">
                        <i class="fas fa-comment"></i> Motif: {{ $auth->motif }}
                    </div>
                    <div class="detail">
                        <i class="fas fa-key"></i> Type d'accès: <strong>{{ ucfirst($auth->type_acces) }}</strong>
                    </div>
                </div>
                <div class="auth-actions">
                    <form action="{{ route('autorisations.update', $auth->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="approuve">
                        <button type="submit" class="btn-approve">
                            <i class="fas fa-check"></i> Accepter
                        </button>
                    </form>
                    <form action="{{ route('autorisations.update', $auth->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="statut" value="refuse">
                        <button type="submit" class="btn-reject">
                            <i class="fas fa-times"></i> Refuser
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">Aucune demande en attente.</div>
        @endforelse
    </div>

    {{-- Accès Actifs --}}
    <div class="auth-section">
        <div class="auth-header active">
            <h3><i class="fas fa-user-md"></i> Médecins Autorisés</h3>
            <p style="margin: 5px 0 0 0; color: #666; font-size: 0.9em;">Liste des professionnels ayant accès à votre
                dossier.</p>
        </div>
        @forelse($autorisations->where('statut', 'approuve') as $auth)
            <div class="auth-item">
                <div class="auth-info">
                    <div class="name">
                        Dr. {{ $auth->medecin->prenom }} {{ $auth->medecin->nom }}
                    </div>
                    <div class="detail">
                        <i class="fas fa-stethoscope"></i> Spécialité: {{ $auth->medecin->specialite->nom ?? 'Généraliste' }}
                    </div>
                    <div class="detail">
                        <i class="fas fa-calendar"></i> Expire le:
                        {{ $auth->date_fin ? $auth->date_fin->format('d/m/Y') : 'Illimité' }}
                    </div>
                </div>
                <div class="auth-actions">
                    <form action="{{ route('autorisations.destroy', $auth->id) }}" method="POST"
                        onsubmit="return confirm('Voulez-vous vraiment révoquer cet accès ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-revoke">
                            <i class="fas fa-ban"></i> Révoquer
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">Aucun médecin autorisé.</div>
        @endforelse
    </div>
@endsection