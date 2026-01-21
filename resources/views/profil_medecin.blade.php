<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil & Paramètres - Médecin - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour la page Profil/Paramètres (Médecin) */
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--color-card-background);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-header h3 {
            color: var(--color-medecin);
            margin-top: 10px;
            font-weight: 400;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            /* Deux colonnes pour la structure principale */
            gap: 30px;
        }

        .settings-card {
            background-color: var(--color-card-background);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .settings-card h3 {
            color: var(--color-medecin);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
            font-size: 1.4em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-list {
            list-style: none;
            padding: 0;
        }

        .action-list li {
            margin-bottom: 15px;
        }

        .action-list a,
        .action-list button {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            color: var(--color-text);
            transition: background-color 0.2s, border-color 0.2s;
            cursor: pointer;
            background-color: white;
            text-align: left;
            font-weight: 500;
        }

        .action-list a:hover,
        .action-list button:hover {
            background-color: #f5f5f5;
            border-color: var(--color-medecin);
        }

        .action-list i {
            margin-right: 15px;
            color: var(--color-medecin);
            min-width: 20px;
        }

        /* Information de Licence */
        .licence-info p {
            font-size: 0.9em;
            margin-bottom: 10px;
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

<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de
                Bord</a>
            <a href="{{ route('mes_patients') }}" class="nav-item"><i class="fas fa-users"></i> Liste des Patients</a>
            <a href="{{ route('messages_medecin') }}" class="nav-item"><i class="fas fa-comments"></i> Messages
                (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="nav-item"><i class="fas fa-hospital-user"></i> Mes
                Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}" class="nav-item active profile-link"><i
                    class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i>
                Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Mon Profil Professionnel</h2>
            <p>Gérez vos informations, votre licence et vos préférences.</p>
        </header>

        <div class="profile-header">
            <i class="fas fa-user-circle" style="font-size: 4em; color: var(--color-medecin);"></i>
            <h3>Dr. {{ $medecin->prenom }} {{ $medecin->nom }} - {{ $medecin->specialite->nom ?? 'Généraliste' }}</h3>
            <p style="font-size: 1.1em; color: #555;">Inscrit depuis le {{ $medecin->created_at->format('d/m/Y') }}</p>
        </div>

        <section class="profile-grid">

            <div class="settings-card">
                <h3><i class="fas fa-user-cog"></i> Gestion du Compte</h3>
                <ul class="action-list">
                    <li>
                        <a href="modifier_infos_medecin.html">
                            <i class="fas fa-edit"></i> Modifier mes Informations Personnelles
                        </a>
                    </li>
                    <li>
                        <a href="modifier_specialite.html">
                            <i class="fas fa-stethoscope"></i> Mettre à jour Spécialité / Compétences
                        </a>
                    </li>
                    <li>
                        <a href="modifier_mdp_medecin.html">
                            <i class="fas fa-key"></i> Changer mon Mot de Passe
                        </a>
                    </li>
                    <li>
                        <a href="desactiver_compte.html" style="color: #D32F2F;">
                            <i class="fas fa-trash-alt"></i> Désactiver mon Compte
                        </a>
                    </li>
                </ul>

                <h3 style="margin-top: 30px;"><i class="fas fa-headset"></i> Centre d'Aide</h3>
                <ul class="action-list">
                    <li>
                        <a href="faq_medecin.html">
                            <i class="fas fa-question-circle"></i> FAQ (Questions Fréquemment Posées)
                        </a>
                    </li>
                    <li>
                        <a href="mailto:support@medilink.com">
                            <i class="fas fa-envelope"></i> Contacter le Support Technique
                        </a>
                    </li>
                </ul>
            </div>

            <div class="settings-card">
                <h3><i class="fas fa-file-signature"></i> Licence & Vérification</h3>
                <div class="licence-info">
                    <p>
                        <strong>Numéro d'enregistrement :</strong> {{ $medecin->numero_licence }}
                    </p>
                    <p>
                        <strong>Statut de la Licence :</strong>
                        @if($medecin->statut == 'actif')
                            <span class="status-badge status-verified">Vérifié et Actif</span>
                        @elseif($medecin->statut == 'en_attente')
                            <span class="status-badge status-pending">En attente de validation</span>
                        @else
                            <span class="status-badge" style="background:#ffebee; color:#c62828;">Inactif / Rejeté</span>
                        @endif
                    </p>
                    <p>
                        <strong>Dernière mise à jour :</strong> {{ $medecin->updated_at->format('d/m/Y') }}
                    </p>

                    <ul class="action-list" style="margin-top: 15px;">
                        <li>
                            <button type="button">
                                <i class="fas fa-upload"></i> Téléverser/Mettre à jour le Certificat
                            </button>
                        </li>
                    </ul>
                </div>

                <h3 style="margin-top: 30px;"><i class="fas fa-book-open"></i> Ressources Pro</h3>
                <ul class="action-list">
                    <li>
                        <a href="guide_utilisation_pro.html" target="_blank">
                            <i class="fas fa-file-pdf"></i> Guide d'utilisation pour Pro
                        </a>
                    </li>
                    <li>
                        <a href="partenariats.html" target="_blank">
                            <i class="fas fa-handshake"></i> Opportunités de Partenariat
                        </a>
                    </li>
                </ul>
            </div>

        </section>
    </div>
</body>

</html>