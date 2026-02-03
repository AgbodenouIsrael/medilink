@extends('layouts.medecin')

@section('title', 'Mes Patients - Dashboard Médecin - Medilink')

@section('styles')
    <style>
        /* Styles spécifiques pour la Liste des Patients */
        .search-patient-bar {
            background-color: white;
            /* was var(--color-card-background) */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
        }

        .search-patient-bar form {
            display: flex;
            gap: 15px;
        }

        .search-patient-bar .input-group {
            flex-grow: 1;
            margin-bottom: 0;
        }

        /* Tableau/Liste des Patients */
        .patients-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            /* was var(--color-card-background) */
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .patients-table th,
        .patients-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .patients-table th {
            background-color: #e8f5e9;
            /* Vert très clair pour l'en-tête */
            color: #2e7d32;
            /* var(--color-medecin) */
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .patients-table tr:hover {
            background-color: #fafafa;
        }

        .patients-table td {
            color: #333;
            /* var(--color-text) */
            font-size: 0.95em;
        }

        .patient-status {
            font-weight: bold;
        }

        .status-stable {
            color: #2e7d32;
            /* var(--color-medecin) */
        }

        /* Vert */
        .status-attention {
            color: #ffc107;
        }

        /* Jaune */
        .status-urgent {
            color: #dc3545;
        }

        /* Rouge */

        .btn-action {
            background-color: #2e7d32;
            /* var(--color-medecin) */
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 0.85em;
            transition: background-color 0.2s;
        }

        .btn-action:hover {
            background-color: #388E3C;
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
        <h2>Mes Patients</h2>
        <p>Liste et gestion de votre clientèle de patients.</p>
    </header>

    <div class="search-patient-bar">
        <form action="{{ url()->current() }}" method="GET" novalidate>
            @csrf
            <div class="input-group">
                <input type="text" name="q" placeholder="Rechercher par Nom, Prénom ou ID Patient..." value="{{ old('q') }}"
                    required>
                @error('q') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn primary-btn" style="background-color: #2e7d32;"><i class="fas fa-search"></i>
                Filtrer</button>
            <a href="{{ route('demande_acces') }}" class="btn primary-btn"
                style="background-color: #ff9800; margin-left: 10px;"><i class="fas fa-user-plus"></i> Nouveau
                Patient</a>
        </form>
    </div>

    <table class="patients-table">
        <thead>
            <tr>
                <th>Nom du Patient</th>
                <th>Age / Genre</th>
                <th>Contact</th>
                <th>Accès</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
                <tr>
                    <td>
                        <strong>{{ $patient->prenom }} {{ $patient->nom }}</strong>
                        <br><span class="text-xs text-gray-500">ID:
                            P{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td>
                        {{ $patient->date_naissance->age }} ans
                        <span class="text-xs text-gray-500">({{ $patient->genre }})</span>
                    </td>
                    <td>{{ $patient->contact }}</td>
                    <td>
                        @php
                            $auth = $patient->pivot;
                        @endphp
                        <span
                            class="badge {{ $auth->type_acces === 'complet' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($auth->type_acces) }}
                        </span>
                        <br><small>Jusqu'au
                            {{ $auth->date_fin ? \Carbon\Carbon::parse($auth->date_fin)->format('d/m/Y') : 'Illimité' }}</small>
                    </td>
                    <td>
                        <a href="{{ route('medecin.patient.show', $patient->id) }}" class="btn-action">Voir Fiche</a>
                        <a href="#" class="btn-action" title="Messagerie"><i class="fas fa-comment"></i></a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 20px;">
                        Aucun patient trouvé. Demandez l'accès via le code patient.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.search-patient-bar form'); if (!form) return;
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