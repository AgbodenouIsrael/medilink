<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil & Paramètres - Hôpital - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour la page Profil/Paramètres (Hôpital) */
        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr; /* Deux colonnes */
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

        .action-list {
            list-style: none;
            padding: 0;
        }

        .action-list li {
            margin-bottom: 15px;
        }

        .action-list a, .action-list button {
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

        .action-list a:hover, .action-list button:hover {
            background-color: #f5f5f5;
            border-color: var(--color-hopital);
        }

        .action-list i {
            margin-right: 15px;
            color: var(--color-hopital);
            min-width: 20px;
        }
        
        /* Bloc Information Résumé */
        .info-summary {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #fcf8ff; /* Très clair pour le violet */
            border-left: 4px solid var(--color-hopital);
            border-radius: 5px;
        }
        .info-summary p {
            font-size: 0.95em;
            margin-bottom: 8px;
        }
        .info-summary strong {
            color: #333;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            display: inline-block;
        }
        .status-verified {
            background-color: #e8f5e9; 
            color: #28a745;
        }
    </style>
</head>
<body class="dashboard-body hopital-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_hopital') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('liste_patients_hopital') }}" class="nav-item"><i class="fas fa-user-injured"></i> Patients Traités</a>
            <a href="{{ route('liste_medecins_hopital') }}" class="nav-item"><i class="fas fa-user-md"></i> Médecins de l'Hôpital</a>
            <a href="{{ route('profil_hopital') }}" class="nav-item active profile-link"><i class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Paramètres de l'Établissement</h2>
            <p>Gérez les informations institutionnelles, les documents légaux et les accès.</p>
        </header>

        <section class="profile-grid">
            
            <div class="settings-card">
                <h3><i class="fas fa-hospital-user"></i> Informations Institutionnelles</h3>
                
                <div class="info-summary">
                    <p><strong>Nom :</strong> Hôpital Central de [Ville]</p>
                    <p><strong>Adresse :</strong> 12 Rue Principale, [Ville]</p>
                    <p><strong>Contact :</strong> +33 1 23 45 67 89</p>
                    <p><strong>Email :</strong> contact@hopitalcentral.com</p>
                    <p><strong>Statut :</strong> <span class="status-badge status-verified">Vérifié par MediLink</span></p>
                </div>
                
                <ul class="action-list">
                    <li>
                        <a href="modifier_infos_hopital.html">
                            <i class="fas fa-edit"></i> Modifier les Coordonnées et l'Adresse
                        </a>
                    </li>
                    <li>
                        <a href="gestion_admin_hopital.html">
                            <i class="fas fa-users-cog"></i> Gérer les Comptes Administrateurs
                        </a>
                    </li>
                    <li>
                        <a href="modifier_mdp_hopital.html">
                            <i class="fas fa-key"></i> Changer le Mot de Passe Admin
                        </a>
                    </li>
                    <li>
                        <button type="button">
                            <i class="fas fa-map-marker-alt"></i> Mettre à jour la Zone de Couverture
                        </button>
                    </li>
                </ul>
            </div>

            <div class="settings-card">
                <h3><i class="fas fa-file-invoice"></i> Documents Légaux</h3>
                <p style="font-size: 0.9em; color: #777; margin-bottom: 15px;">Vos documents sont nécessaires pour la validité de votre compte.</p>
                
                <ul class="action-list">
                    <li>
                        <a href="#" target="_blank">
                            <i class="fas fa-file-pdf"></i> Voir le Fichier d'Enregistrement Légal
                        </a>
                    </li>
                    <li>
                        <button type="button">
                            <i class="fas fa-upload"></i> Téléverser/Mettre à jour le Fichier
                        </button>
                    </li>
                </ul>

                <h3 style="margin-top: 30px;"><i class="fas fa-headset"></i> Support & Aide</h3>
                <ul class="action-list">
                    <li>
                        <a href="faq_hopital.html">
                            <i class="fas fa-question-circle"></i> FAQ pour les Établissements
                        </a>
                    </li>
                    <li>
                        <a href="mailto:support_pro@medilink.com">
                            <i class="fas fa-envelope"></i> Contacter le Support Pro
                        </a>
                    </li>
                    <li>
                        <a href="conditions_partenariat.html" target="_blank">
                            <i class="fas fa-handshake"></i> Conditions de Partenariat
                        </a>
                    </li>
                </ul>
            </div>

        </section>
    </div>
</body>
</html>