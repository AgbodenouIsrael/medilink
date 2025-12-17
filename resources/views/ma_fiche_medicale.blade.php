<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dossier Médical - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le Dossier Médical */
        .medical-record-sections {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .medical-section {
            background-color: var(--color-card-background);
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--theme-color); /* Bordure de couleur du thème Patient */
        }

        .medical-section h3 {
            color: var(--theme-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .medical-section h3 i {
            font-size: 1.2em;
        }

        .medical-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
        }

        .info-item label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
            font-size: 0.9em;
        }

        .info-item p {
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 10px;
            border-radius: 5px;
            word-wrap: break-word; /* Pour éviter le dépassement du texte */
        }

        /* Styles pour les listes d'historique */
        .history-list {
            list-style: none;
            padding: 0;
        }

        .history-list li {
            background-color: #fcfcfc;
            border: 1px solid #e9e9e9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 7px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .history-list li span {
            color: #777;
            font-size: 0.9em;
        }
        
        .history-list li strong {
            color: var(--color-text);
        }

        .no-data {
            color: #777;
            font-style: italic;
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }

        /* Documents importés */
        .document-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px dashed #eee;
        }

        .document-item:last-child {
            border-bottom: none;
        }

        .document-item i {
            font-size: 1.5em;
            color: #888;
        }

        .document-item a {
            color: var(--color-primary-blue);
            text-decoration: none;
            font-weight: 500;
        }
        .document-item a:hover {
            text-decoration: underline;
        }

        .btn-edit-profile {
            background-color: #ffc107; /* Jaune d'avertissement */
            color: #333;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-edit-profile:hover {
            background-color: #e0a800;
        }
        .section-actions {
            text-align: right;
            margin-top: 20px;
        }
    </style>
</head>
<body class="dashboard-body patient-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_patient') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="#" class="nav-item active"><i class="fas fa-file-medical"></i> Dossier Médical</a>
            <a href="{{ route('trouver_pharmacie') }}" class="nav-item"><i class="fas fa-prescription-bottle-alt"></i> Pharmacies</a>
            <a href="{{ route('mes_messages') }}" class="nav-item"><i class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}" class="nav-item"><i class="fas fa-hospital-alt"></i> Guide des Hôpitaux</a>
            <a href="{{ route('profil_patient') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Mon Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Mon Dossier Médical</h2>
            <p>Consultez et gérez vos informations de santé.</p>
        </header>

        <section class="medical-record-sections">
            
            <div class="medical-section">
                <h3><i class="fas fa-user-circle"></i> Informations Personnelles</h3>
                <div class="medical-info-grid">
                    <div class="info-item">
                        <label>Nom Complet</label>
                        <p>Jean Dupont</p>
                    </div>
                    <div class="info-item">
                        <label>Date de Naissance</label>
                        <p>15/05/1990</p>
                    </div>
                    <div class="info-item">
                        <label>Genre</label>
                        <p>Homme</p>
                    </div>
                    <div class="info-item">
                        <label>Contact</label>
                        <p>+33 6 12 34 56 78</p>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <p>jean.dupont@example.com</p>
                    </div>
                    <div class="info-item">
                        <label>Adresse</label>
                        <p>12 Rue de la Santé, Paris</p>
                    </div>
                </div>
                <div class="section-actions">
                    <a href="{{ route('profil_patient') }}" class="btn primary-btn small-btn">Modifier les informations</a>
                </div>
            </div>

            <div class="medical-section">
                <h3><i class="fas fa-history"></i> Antécédents Médicaux</h3>
                <ul class="history-list">
                    <li>
                        <strong>Allergie</strong>: Pollen <span>(Depuis 2005)</span>
                    </li>
                    <li>
                        <strong>Chirurgie</strong>: Appendicectomie <span>(2010)</span>
                    </li>
                    <li>
                        <strong>Maladie Chronique</strong>: Asthme <span>(Diagnostiqué en 2008)</span>
                    </li>
                    <p class="no-data">Aucun autre antécédent médical majeur enregistré.</p>
                </ul>
            </div>

            <div class="medical-section">
                <h3><i class="fas fa-clipboard-list"></i> Historique des Diagnostics</h3>
                <ul class="history-list">
                    <li>
                        <strong>Grippe saisonnière</strong> - Dr. Martin <span>(12/03/2023)</span>
                    </li>
                    <li>
                        <strong>Infection ORL</strong> - Dr. Dubois <span>(05/01/2023)</span>
                    </li>
                    <li>
                        <strong>Fracture poignet</strong> - Hôpital St. Louis <span>(20/07/2022)</span>
                    </li>
                </ul>
                <p class="no-data" style="background-color: transparent;">Historique des diagnostics vide.</p>
            </div>

            <div class="medical-section">
                <h3><i class="fas fa-pills"></i> Traitements en Cours</h3>
                <ul class="history-list">
                    <li>
                        <strong>Ventoline</strong> (Asthme) - 2 bouffées si besoin <span>(Débuté le 08/08/2008)</span>
                    </li>
                    <li>
                        <strong>Paracétamol</strong> (Douleur occasionnelle) <span>(Prescrit par Dr. Martin)</span>
                    </li>
                </ul>
                <p class="no-data">Aucun traitement en cours actuellement.</p>
            </div>

            <div class="medical-section">
                <h3><i class="fas fa-file-medical-alt"></i> Documents Importés</h3>
                <div class="document-list">
                    <div class="document-item">
                        <i class="fas fa-file-pdf"></i>
                        <a href="#" target="_blank">Compte-rendu radio poignet (2022).pdf</a>
                    </div>
                    <div class="document-item">
                        <i class="fas fa-file-image"></i>
                        <a href="#" target="_blank">Ordonnance_Ventoline_2023.jpg</a>
                    </div>
                    <div class="document-item">
                        <i class="fas fa-file-alt"></i>
                        <a href="#" target="_blank">Analyses_sanguines_10_02_2023.pdf</a>
                    </div>
                    <p class="no-data" style="background-color: transparent;">Aucun document importé pour le moment.</p>
                </div>
                <div class="section-actions">
                    <button class="btn primary-btn small-btn">
                        <i class="fas fa-upload"></i> Importer un nouveau document
                    </button>
                </div>
            </div>

        </section>
    </div>
</body>
</html>