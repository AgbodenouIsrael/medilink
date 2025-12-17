<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Patients - Dashboard Médecin - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour la Liste des Patients */
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
        }

        .search-patient-bar .input-group {
            flex-grow: 1;
            margin-bottom: 0;
        }

        /* Tableau/Liste des Patients */
        .patients-table {
            width: 100%;
            border-collapse: collapse;
            background-color: var(--color-card-background);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .patients-table th, .patients-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }

        .patients-table th {
            background-color: #e8f5e9; /* Vert très clair pour l'en-tête */
            color: var(--color-medecin);
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

        .patient-status {
            font-weight: bold;
        }

        .status-stable { color: var(--color-medecin); } /* Vert */
        .status-attention { color: #ffc107; } /* Jaune */
        .status-urgent { color: #dc3545; } /* Rouge */
        
        .btn-action {
            background-color: var(--color-medecin);
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
    </style>
</head>
<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="#" class="nav-item active"><i class="fas fa-users"></i> Liste des Patients</a>
            <a href="{{ route('messages_medecin') }}" class="nav-item"><i class="fas fa-comments"></i> Messages (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="nav-item"><i class="fas fa-hospital-user"></i> Mes Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Mes Patients</h2>
            <p>Liste et gestion de votre clientèle de patients.</p>
        </header>

        <div class="search-patient-bar">
            <form>
                <div class="input-group">
                    <input type="text" placeholder="Rechercher par Nom, Prénom ou ID Patient..." required>
                </div>
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-medecin);"><i class="fas fa-search"></i> Filtrer</button>
            </form>
        </div>

        <table class="patients-table">
            <thead>
                <tr>
                    <th>Nom du Patient</th>
                    <th>Dernier Diagnostic</th>
                    <th>Statut Actuel</th>
                    <th>Dernière Consultation</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jean Dupont (ID: P0012)</td>
                    <td>Grippe saisonnière</td>
                    <td class="patient-status status-stable">Stable</td>
                    <td>15/11/2025</td>
                    <td>
                        <a href="fiche_patient_0012.html" class="btn-action">Voir Fiche</a>
                        <a href="messages_medecin.html#P0012" class="btn-action"><i class="fas fa-comment"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Fatou Camara (ID: P0045)</td>
                    <td>Hypotension</td>
                    <td class="patient-status status-attention">À Suivre</td>
                    <td>01/12/2025</td>
                    <td>
                        <a href="fiche_patient_0045.html" class="btn-action">Voir Fiche</a>
                        <a href="messages_medecin.html#P0045" class="btn-action"><i class="fas fa-comment"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>Marc Talla (ID: P0008)</td>
                    <td>Fracture poignet</td>
                    <td class="patient-status status-urgent">Post-Op Urgent</td>
                    <td>Hier</td>
                    <td>
                        <a href="fiche_patient_0008.html" class="btn-action">Voir Fiche</a>
                        <a href="messages_medecin.html#P0008" class="btn-action"><i class="fas fa-comment"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>