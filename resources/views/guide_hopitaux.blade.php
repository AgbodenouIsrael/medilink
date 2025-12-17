<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guide des Hôpitaux - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le Guide des Hôpitaux */
        .hospitals-container {
            display: flex;
            gap: 20px;
        }

        .map-section {
            flex-basis: 60%; /* Espace pour la carte (placeholder) */
            height: 500px;
            background-color: #e0e0e0; /* Placeholder pour la carte */
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .map-placeholder-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #555;
            font-size: 1.2em;
            text-align: center;
        }

        .list-section {
            flex-basis: 40%;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .search-controls {
            background-color: var(--color-card-background);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
        }

        .hospital-card {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9e9e9;
            transition: border-color 0.3s;
        }
        
        .hospital-card:hover {
            border-color: var(--color-patient);
        }

        .hospital-card h4 {
            color: var(--color-patient);
            margin-bottom: 5px;
            font-size: 1.1em;
        }

        .hospital-card p {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
        }
        
        .hospital-card .actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .actions .btn {
            padding: 7px 12px;
            font-size: 0.85em;
        }

        .btn-itineraire {
            background-color: #6c757d; /* Gris */
        }
        .btn-itineraire:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body class="dashboard-body patient-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_patient') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('ma_fiche_medicale') }}" class="nav-item"><i class="fas fa-file-medical"></i> Dossier Médical</a>
            <a href="{{ route('trouver_pharmacie') }}" class="nav-item"><i class="fas fa-prescription-bottle-alt"></i> Pharmacies</a>
            <a href="{{ route('mes_messages') }}" class="nav-item"><i class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}" class="nav-item active"><i class="fas fa-hospital-alt"></i> Guide des Hôpitaux</a>
            <a href="{{ route('profil') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Mon Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Guide des Hôpitaux & Centres de Santé</h2>
            <p>Trouvez un établissement de santé, demandez un rendez-vous ou obtenez un itinéraire.</p>
        </header>

        <div class="hospitals-container">
            <div class="map-section">
                <div class="map-placeholder-text">
                    [Placeholder de Carte Interactive (Google Maps ou autre)]
                    <br><br>Affichage des centres de santé proches.
                </div>
            </div>

            <div class="list-section">
                
                <div class="search-controls">
                    <div class="input-group">
                        <label for="specialite_recherche"><i class="fas fa-search"></i> Recherche par Spécialité / Soins</label>
                        <select id="specialite_recherche" name="specialite" required>
                            <option value="">Toutes les spécialités...</option>
                            <option value="urgence">Urgence</option>
                            <option value="cardiologie">Cardiologie</option>
                            <option value="pediatrie">Pédiatrie</option>
                            </select>
                    </div>
                    <button class="btn primary-btn" style="width: 100%; margin-top: 10px;"><i class="fas fa-filter"></i> Filtrer</button>
                </div>

                <h3>Centres à proximité (3 résultats)</h3>

                <div class="hospital-card">
                    <h4>Hôpital Universitaire
                        <span style="font-size: 0.8em; color: green;"> (1.2 km)</span>
                    </h4>
                    <p><i class="fas fa-notes-medical"></i> Type de Soins: Urgence, Chirurgie, Maternité</p>
                    <p><i class="fas fa-info-circle"></i> Ouvert 24/7</p>
                    <div class="actions">
                        <a href="#" class="btn primary-btn small-btn">Demander RDV</a>
                        <a href="#" class="btn small-btn btn-itineraire"><i class="fas fa-directions"></i> Voir Itinéraire</a>
                    </div>
                </div>

                <div class="hospital-card">
                    <h4>Clinique Mère & Enfant
                        <span style="font-size: 0.8em; color: #555;"> (3.5 km)</span>
                    </h4>
                    <p><i class="fas fa-notes-medical"></i> Type de Soins: Pédiatrie, Gynécologie</p>
                    <p><i class="fas fa-info-circle"></i> Horaires: 8h - 18h</p>
                    <div class="actions">
                        <a href="#" class="btn primary-btn small-btn">Demander RDV</a>
                        <a href="#" class="btn small-btn btn-itineraire"><i class="fas fa-directions"></i> Voir Itinéraire</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>