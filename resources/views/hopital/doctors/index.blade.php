@extends('layouts.hopital')

@section('title', 'Personnel Médical - Dashboard Hôpital - Medilink')

@section('styles')
    <style>
        /* Styles spécifiques pour la Liste des Médecins */
        .search-medecin-bar {
            background-color: var(--color-card-background);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
        }

        .search-medecin-bar form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }

        .search-medecin-bar .input-group {
            flex-grow: 1;
            margin-bottom: 0;
        }

        .medecins-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--color-card-background);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .medecins-table th,
        .medecins-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .medecins-table th {
            background-color: #f3e5f5;
            /* Violet très clair pour l'en-tête */
            color: var(--color-hopital);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .medecins-table tr:hover {
            background-color: #fafafa;
        }

        .medecins-table td {
            color: var(--color-text);
            font-size: 0.95em;
        }

        .medecin-status {
            font-weight: bold;
        }

        .status-actif {
            color: var(--color-medecin);
        }

        /* Vert */
        .status-conge {
            color: #ffc107;
        }

        /* Jaune */
        .status-inactif {
            color: #6c757d;
        }

        /* Gris */

        .btn-action {
            background-color: var(--color-hopital);
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.85em;
            transition: background-color 0.2s;
        }

        .btn-action:hover {
            background-color: #7b1fa2;
        }

        .btn-add-medecin {
            background-color: var(--color-hopital);
            color: white;
            margin-bottom: 20px;
            display: inline-block;
        }

        .error-msg {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 4px;
            display: block;
        }

        .input-error {
            border-color: #dc3545 !important;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Gestion du Personnel Médical</h2>
        <p>Liste des médecins affiliés à votre établissement et leur statut.</p>
    </header>

    @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($pending->count() > 0)
        <div class="settings-card" style="margin-bottom: 30px; border-left: 4px solid #ffc107;">
            <h3 style="color: #ffc107;"><i class="fas fa-clock"></i> Demandes d'Affiliation en Attente
                ({{ $pending->count() }})</h3>
            <p style="margin-bottom: 15px; color: #666;">Les médecins suivants ont demandé à rejoindre votre
                établissement.</p>

            @foreach($pending as $medecin)
                <div
                    style="background: #fff3cd; padding: 15px; margin-bottom: 10px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <strong>Dr. {{ $medecin->prenom }} {{ $medecin->nom }}</strong><br>
                        <small>{{ $medecin->specialite->nom ?? 'Généraliste' }} | {{ $medecin->email }}</small>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <form action="{{ route('hopital.medecin.approve', $medecin->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-action" style="background: #28a745;">
                                <i class="fas fa-check"></i> Approuver
                            </button>
                        </form>
                        <form action="{{ route('hopital.medecin.reject', $medecin->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-action" style="background: #dc3545;">
                                <i class="fas fa-times"></i> Rejeter
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <h3 style="margin-bottom: 15px; color: #444;">Médecins Actifs ({{ $medecins->count() }})</h3>

    <a href="#" class="btn primary-btn btn-add-medecin"
        onclick="alert('Fonctionnalité à venir : Les médecins doivent demander à rejoindre votre établissement depuis leur compte.'); return false;"><i
            class="fas fa-plus"></i> Affilier un Nouveau Médecin</a>

    <div class="search-medecin-bar">
        <form action="{{ url()->current() }}" method="GET" novalidate>
            @csrf
            <div class="input-group">
                <input type="text" name="q" placeholder="Rechercher par Nom, Prénom ou ID Médecin..." value="{{ old('q') }}"
                    required>
                @error('q') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="input-group">
                <select name="specialite">
                    <option value="">Filtrer par Spécialité</option>
                    <option value="cardiologie" {{ old('specialite') == 'cardiologie' ? 'selected' : '' }}>Cardiologie
                    </option>
                    <option value="pediatrie" {{ old('specialite') == 'pediatrie' ? 'selected' : '' }}>Pédiatrie
                    </option>
                    <option value="chirurgie" {{ old('specialite') == 'chirurgie' ? 'selected' : '' }}>Chirurgie
                    </option>
                </select>
                @error('specialite') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn primary-btn" style="background-color: var(--color-hopital);"><i
                    class="fas fa-filter"></i> Filtrer</button>
        </form>
    </div>

    <table class="medecins-table">
        <thead>
            <tr>
                <th>Nom du Médecin</th>
                <th>Spécialité</th>
                <th>Statut/Disponibilité</th>
                <th>Email Professionnel</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($medecins as $medecin)
                <tr>
                    <td><strong>Dr. {{ $medecin->prenom }} {{ $medecin->nom }}</strong></td>
                    <td>{{ $medecin->specialite->nom ?? 'Généraliste' }}</td>
                    <td class="medecin-status {{ $medecin->pivot->statut === 'actif' ? 'status-actif' : 'status-inactif' }}">
                        {{ ucfirst($medecin->pivot->statut) }}
                    </td>
                    <td>{{ $medecin->email }}</td>
                    <td>
                        <a href="#" class="btn-action">Voir Profil</a>
                        <a href="#" class="btn-action"><i class="fas fa-calendar-alt"></i> Horaires</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">
                        Aucun médecin affilié pour le moment.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.search-medecin-bar form'); if (!form) return;
            const submitBtn = form.querySelector('button[type="submit"]');
            form.addEventListener('submit', function (e) {
                form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
                let invalid = false;
                form.querySelectorAll('[required]').forEach(function (el) { if (!el.value || !el.value.toString().trim()) { invalid = true; el.classList.add('input-error'); } });
                if (invalid) { e.preventDefault(); const first = form.querySelector('.input-error'); if (first) first.focus(); return; }
                if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ...'; }
            });
        });
    </script>
@endsection