<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Médical - Dashboard Hôpital - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        .medecins-table th, .medecins-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .medecins-table th {
            background-color: #f3e5f5; /* Violet très clair pour l'en-tête */
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

        .status-actif { color: var(--color-medecin); } /* Vert */
        .status-conge { color: #ffc107; } /* Jaune */
        .status-inactif { color: #6c757d; } /* Gris */
        
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
    </style>
</head>
<body class="dashboard-body hopital-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_hopital') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('liste_patients_hopital') }}" class="nav-item"><i class="fas fa-user-injured"></i> Patients Traités</a>
            <a href="#" class="nav-item active"><i class="fas fa-user-md"></i> Médecins de l'Hôpital</a>
            <a href="{{ route('profil_hopital') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Gestion du Personnel Médical</h2>
            <p>Liste des médecins affiliés à votre établissement et leur statut.</p>
        </header>

        <a href="#" class="btn primary-btn btn-add-medecin"><i class="fas fa-plus"></i> Affilier un Nouveau Médecin</a>

        <div class="search-medecin-bar">
            <form>
                <div class="input-group">
                    <input type="text" placeholder="Rechercher par Nom, Prénom ou ID Médecin..." required>
                </div>
                 <div class="input-group">
                    <select>
                        <option value="">Filtrer par Spécialité</option>
                        <option value="cardiologie">Cardiologie</option>
                        <option value="pediatrie">Pédiatrie</option>
                        <option value="chirurgie">Chirurgie</option>
                    </select>
                </div>
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-hopital);"><i class="fas fa-filter"></i> Filtrer</button>
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
                <tr>
                    <td>Dr. Martin Dubois</td>
                    <td>Pédiatrie</td>
                    <td class="medecin-status status-actif">Actif (Sur site)</td>
                    <td>m.dubois@medilink.com</td>
                    <td>
                        <a href="profil_medecin_detail.html" class="btn-action">Voir Profil</a>
                        <a href="#" class="btn-action"><i class="fas fa-calendar-alt"></i> Horaires</a>
                    </td>
                </tr>
                <tr>
                    <td>Dr. Sophie Leloup</td>
                    <td>Cardiologie</td>
                    <td class="medecin-status status-conge">En Congé (Retour 12/02)</td>
                    <td>s.leloup@medilink.com</td>
                    <td>
                        <a href="profil_medecin_detail.html" class="btn-action">Voir Profil</a>
                        <a href="#" class="btn-action"><i class="fas fa-times-circle"></i> Désaffilier</a>
                    </td>
                </tr>
                <tr>
                    <td>Dr. Elias Kante</td>
                    <td>Chirurgie Orthopédique</td>
                    <td class="medecin-status status-actif">Actif (Télétravail)</td>
                    <td>e.kante@medilink.com</td>
                    <td>
                        <a href="profil_medecin_detail.html" class="btn-action">Voir Profil</a>
                        <a href="#" class="btn-action"><i class="fas fa-calendar-alt"></i> Horaires</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>