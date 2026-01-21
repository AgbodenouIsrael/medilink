<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patients Traités - Dashboard Hôpital - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour la Liste des Patients (Hôpital) */
        .search-patient-bar {
            background-color: var(--color-card-background);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
        }

        .search-patient-bar form {
            display: flex;
            gap: 15px;
            align-items: flex-end;
        }

        .search-patient-bar .input-group {
            flex-grow: 1;
            margin-bottom: 0;
        }

        .patients-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--color-card-background);
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
            background-color: #f3e5f5;
            /* Violet très clair pour l'en-tête */
            color: var(--color-hopital);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .patients-table tr:hover {
            background-color: #fafafa;
        }

        .patients-table td {
            color: var(--color-text);
            font-size: 0.95em;
        }

        .patient-type-badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8em;
            font-weight: bold;
        }

        .type-admis {
            background-color: #ffebee;
            color: #dc3545;
        }

        .type-consult {
            background-color: #e8f5e9;
            color: var(--color-medecin);
        }

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
</head>

<body class="dashboard-body hopital-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_hopital') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de
                Bord</a>
            <a href="{{ route('liste_patients_hopital') }}" class="nav-item active"><i class="fas fa-user-injured"></i>
                Patients Traités</a>
            <a href="{{ route('liste_medecins_hopital') }}" class="nav-item"><i class="fas fa-user-md"></i> Médecins de
                l'Hôpital</a>
            <a href="{{ route('profil_hopital') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i>
                Paramètres & Profil</a>
            <a href="{{ route('connexion') }}   " class="nav-item logout"><i class="fas fa-sign-out-alt"></i>
                Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Historique des Patients Traités</h2>
            <p>Consultez la liste des patients ayant bénéficié de soins ou d'une consultation dans votre établissement.
            </p>
            <div
                style="background: #e3f2fd; padding: 12px; border-radius: 6px; margin-top: 10px; border-left: 4px solid var(--color-hopital);">
                <i class="fas fa-info-circle"></i> <strong>Note:</strong> Les patients apparaissent ici lorsqu'un
                médecin leur accorde une autorisation d'accès au dossier pour votre établissement.
            </div>
        </header>

        <div class="search-patient-bar">
            <form action="{{ url()->current() }}" method="GET" novalidate>
                @csrf
                <div class="input-group">
                    <input type="text" name="q" placeholder="Rechercher par Nom, ID ou Date..." value="{{ old('q') }}"
                        required>
                    @error('q') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="input-group">
                    <select name="type_soin">
                        <option value="">Filtrer par Type de Soin</option>
                        <option value="admission" {{ old('type_soin') == 'admission' ? 'selected' : '' }}>Admission
                            (Urgence)</option>
                        <option value="consultation" {{ old('type_soin') == 'consultation' ? 'selected' : '' }}>
                            Consultation Externe</option>
                        <option value="chirurgie" {{ old('type_soin') == 'chirurgie' ? 'selected' : '' }}>Chirurgie
                        </option>
                    </select>
                    @error('type_soin') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-hopital);"><i
                        class="fas fa-filter"></i> Filtrer</button>
            </form>
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
        </div>

        <table class="patients-table">
            <thead>
                <tr>
                    <th>Nom du Patient</th>
                    <th>Type de Soin</th>
                    <th>Date de Fin/Sortie</th>
                    <th>Médecin Responsable</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr>
                        <td>
                            <strong>{{ $patient->prenom }} {{ $patient->nom }}</strong>
                            <br><small>ID: P{{ str_pad($patient->id, 4, '0', STR_PAD_LEFT) }}</small>
                        </td>
                        <td>
                            <span class="patient-type-badge type-consult">
                                {{ ucfirst($patient->pivot->type_acces) }}
                            </span>
                        </td>
                        <td>{{ $patient->pivot->date_fin ? \Carbon\Carbon::parse($patient->pivot->date_fin)->format('d/m/Y') : 'Illimité' }}
                        </td>
                        <td>
                            @if($patient->pivot->medecin_id)
                                {{ \App\Models\Medecin::find($patient->pivot->medecin_id)->nom ?? 'Non assigné' }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <a href="#" class="btn-action">Voir Dossier</a>
                            <a href="#" class="btn-action"><i class="fas fa-file-pdf"></i> Rapport</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px;">
                            Aucun patient enregistré.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>

</html>