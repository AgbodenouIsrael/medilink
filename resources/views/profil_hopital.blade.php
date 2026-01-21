<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Hôpital - MediLink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--color-card-background);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-header h3 {
            color: var(--color-hopital);
            margin-top: 10px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .settings-card {
            background-color: var(--color-card-background);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .settings-card h3 {
            color: var(--color-hopital);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
            font-size: 1.4em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 3px solid var(--color-hopital);
            background: #f9f9f9;
        }

        .info-row strong {
            color: #555;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
        }

        .status-verified {
            background-color: #e8f5e9;
            color: #28a745;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #ffc107;
        }
    </style>
</head>

<body class="dashboard-body hopital-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_hopital') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de
                Bord</a>
            <a href="{{ route('liste_patients_hopital') }}" class="nav-item"><i class="fas fa-user-injured"></i>
                Patients Traités</a>
            <a href="{{ route('liste_medecins_hopital') }}" class="nav-item"><i class="fas fa-user-md"></i> Médecins de
                l'Hôpital</a>
            <a href="{{ route('profil_hopital') }}" class="nav-item active profile-link"><i
                    class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('logout.hopital') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
        <form id="logout-form" action="{{ route('logout.hopital') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Profil de l'Établissement</h2>
            <p>Gérez les informations de votre hôpital/clinique.</p>
        </header>

        <div class="profile-header">
            <i class="fas fa-hospital-user" style="font-size: 4em; color: var(--color-hopital);"></i>
            <h3>{{ $hopital->nom }}</h3>
            <p style="font-size: 1.1em; color: #555;">Inscrit depuis le {{ $hopital->created_at->format('d/m/Y') }}</p>
        </div>

        <section class="profile-grid">
            <div class="settings-card">
                <h3><i class="fas fa-info-circle"></i> Informations de l'Établissement</h3>

                <div class="info-row">
                    <strong>Nom :</strong> {{ $hopital->nom }}
                </div>

                <div class="info-row">
                    <strong>Email Institutionnel :</strong> {{ $hopital->email }}
                </div>

                <div class="info-row">
                    <strong>Contact :</strong> {{ $hopital->contact }}
                </div>

                <div class="info-row">
                    <strong>Adresse :</strong> {{ $hopital->adresse }}
                </div>

                <div class="info-row">
                    <strong>Ville/Zone :</strong> {{ $hopital->zone->nom ?? 'Non définie' }}
                    ({{ $hopital->zone->ville ?? '' }})
                </div>
            </div>

            <div class="settings-card">
                <h3><i class="fas fa-check-circle"></i> Statut & Validation</h3>

                <div class="info-row">
                    <strong>Statut de l'établissement :</strong><br>
                    @if($hopital->statut == 'verifie')
                        <span class="status-badge status-verified">Vérifié et Actif</span>
                    @elseif($hopital->statut == 'en_attente')
                        <span class="status-badge status-pending">En attente de validation</span>
                    @else
                        <span class="status-badge" style="background:#ffebee; color:#c62828;">Rejeté</span>
                    @endif
                </div>

                <div class="info-row">
                    <strong>Dernière mise à jour :</strong><br>
                    {{ $hopital->updated_at->format('d/m/Y H:i') }}
                </div>

                <h3 style="margin-top: 30px;"><i class="fas fa-chart-line"></i> Statistiques</h3>

                <div class="info-row">
                    <strong>Médecins affiliés :</strong> {{ $hopital->medecins()->count() }}
                </div>

                <div class="info-row">
                    <strong>Patients traités :</strong> {{ $hopital->patients()->count() }}
                </div>
            </div>
        </section>
    </div>
</body>

</html>