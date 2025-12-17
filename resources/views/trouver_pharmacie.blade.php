<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trouver une Pharmacie - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour la recherche de Pharmacie */
        .search-container {
            background-color: var(--color-card-background);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border-left: 5px solid var(--color-patient); /* Thème Bleu Patient */
        }
        
        .search-form {
            display: flex;
            gap: 20px;
            align-items: flex-end;
        }

        .search-form .input-group {
            flex: 1;
            margin-bottom: 0;
        }

        .search-form button {
            padding: 12px 25px;
            background-color: var(--color-patient);
            color: white;
        }

        /* Liste des Résultats */
        .pharmacy-results {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pharmacy-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid var(--color-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.2s;
        }

        .pharmacy-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .pharmacy-info h4 {
            color: var(--color-patient);
            margin-bottom: 5px;
            font-size: 1.2em;
        }

        .pharmacy-info p {
            color: #555;
            font-size: 0.9em;
            margin: 3px 0;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            margin-left: 10px;
            display: inline-block;
        }

        .open {
            background-color: #e8f5e9; /* Vert très clair */
            color: #4CAF50;
        }

        .closed {
            background-color: #ffebee; /* Rouge très clair */
            color: #F44336;
        }

        .pharmacy-actions .btn {
            background-color: var(--color-patient);
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            font-size: 0.9em;
        }

        .pharmacy-actions .btn:hover {
            background-color: #1976D2;
        }
        
    </style>
</head>
<body class="dashboard-body patient-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_patient') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('ma_fiche_medicale') }}" class="nav-item"><i class="fas fa-file-medical"></i> Dossier Médical</a>
            <a href="{{ route('trouver_pharmacie') }}" class="nav-item active"><i class="fas fa-prescription-bottle-alt"></i> Pharmacies</a>
            <a href="{{ route('mes_messages') }}" class="nav-item"><i class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}" class="nav-item"><i class="fas fa-hospital-alt"></i> Guide des Hôpitaux</a>
            <a href="{{ route('profil') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Mon Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Trouver une Pharmacie</h2>
            <p>Recherchez les pharmacies de votre zone et vérifiez la disponibilité des médicaments.</p>
        </header>

        <div class="search-container">
            <form class="search-form">
                <div class="input-group">
                    <label for="zone_search"><i class="fas fa-map-marker-alt"></i> Ma Zone</label>
                    <input type="text" id="zone_search" name="zone" placeholder="Ex: Paris 15e, Lomé centre" value="[Zone du patient]" required>
                </div>
                
                <div class="input-group">
                    <label for="medicament_search"><i class="fas fa-pills"></i> Recherche de Médicament (Optionnel)</label>
                    <input type="text" id="medicament_search" name="medicament" placeholder="Ex: Paracétamol, Amoxicilline">
                </div>
                
                <button type="submit" class="btn primary-btn"><i class="fas fa-search"></i> Rechercher</button>
            </form>
        </div>

        <h3>Résultats dans la zone [Zone du patient]</h3>
        
        <section class="pharmacy-results">
            
            <div class="pharmacy-card">
                <div class="pharmacy-info">
                    <h4>Pharmacie Centrale
                        <span class="status-badge open">Ouverte</span>
                    </h4>
                    <p><i class="fas fa-map-pin"></i> 15 Rue de l'Avenue, [Zone du patient]</p>
                    <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
                    <p>
                        <i class="fas fa-flask"></i> 
                        **Stock:** Paracétamol (Disponible), Amoxicilline (Rupture)
                    </p>
                </div>
                <div class="pharmacy-actions">
                    <a href="#" class="btn primary-btn"><i class="fas fa-route"></i> Voir Itinéraire</a>
                </div>
            </div>
            
            <div class="pharmacy-card">
                <div class="pharmacy-info">
                    <h4>Pharmacie de la Liberté
                         <span class="status-badge closed">Fermée (Ouvre à 8h)</span>
                    </h4>
                    <p><i class="fas fa-map-pin"></i> 45 Bd. de l'Espoir, [Zone du patient]</p>
                    <p><i class="fas fa-phone"></i> +33 1 98 76 54 32</p>
                    <p>
                        <i class="fas fa-flask"></i> 
                        **Stock:** Paracétamol (Rupture), Ibuprofène (Disponible)
                    </p>
                </div>
                <div class="pharmacy-actions">
                    <a href="#" class="btn primary-btn"><i class="fas fa-route"></i> Voir Itinéraire</a>
                </div>
            </div>
            
            <div class="pharmacy-card">
                <div class="pharmacy-info">
                    <h4>Pharmacie de Garde
                        <span class="status-badge open">Ouverte 24/7</span>
                    </h4>
                    <p><i class="fas fa-map-pin"></i> Près du Grand Hôpital, [Zone du patient]</p>
                    <p><i class="fas fa-phone"></i> +33 1 11 22 33 44</p>
                    <p><i class="fas fa-flask"></i> Vérification du stock disponible sur demande</p>
                </div>
                <div class="pharmacy-actions">
                    <a href="#" class="btn primary-btn"><i class="fas fa-route"></i> Voir Itinéraire</a>
                </div>
            </div>

        </section>
    </div>
</body>
</html>