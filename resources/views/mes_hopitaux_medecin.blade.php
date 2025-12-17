<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Hôpitaux & Cabinets - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour la gestion des lieux d'exercice */
        .location-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
        }

        .location-card {
            background-color: var(--color-card-background);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--color-medecin);
        }

        .location-card h3 {
            color: var(--color-medecin);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.3em;
        }

        .location-card p {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 5px;
        }
        
        .location-card .details {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px dashed #eee;
        }

        /* Horaires d'activité */
        .schedule-list {
            list-style: none;
            padding: 0;
            margin-top: 10px;
        }

        .schedule-list li {
            display: flex;
            justify-content: space-between;
            font-size: 0.9em;
            padding: 5px 0;
            border-bottom: 1px dotted #f0f0f0;
        }

        .schedule-list li:last-child {
            border-bottom: none;
        }

        .schedule-list strong {
            color: #333;
        }
        
        /* Boutons d'action */
        .location-actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        
        .btn-schedule {
            background-color: #ffc107; /* Jaune */
            color: #333;
        }
        .btn-schedule:hover {
            background-color: #e0a800;
        }
        
        .btn-refer {
            background-color: #6c757d; /* Gris */
        }
        .btn-refer:hover {
            background-color: #5a6268;
        }

        .btn-add {
            width: 100%;
            margin-top: 20px;
            background-color: #28a745; /* Vert foncé */
        }
    </style>
</head>
<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('mes_patients') }}" class="nav-item"><i class="fas fa-users"></i> Liste des Patients</a>
            <a href="{{ route('messages_medecin') }}" class="nav-item"><i class="fas fa-comments"></i> Messages (Chat)</a>
            <a href="#" class="nav-item active"><i class="fas fa-hospital-user"></i> Mes Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Gestion des Lieux d'Exercice</h2>
            <p>Visualisez et gérez vos heures d'activité et vos lieux de consultation.</p>
        </header>

        <section class="location-grid">
            
            <div class="location-card">
                <h3><i class="fas fa-hospital-alt"></i> Hôpital Universitaire Central</h3>
                <p><i class="fas fa-map-marker-alt"></i> **Adresse :** 10 Rue des Grandes Soins</p>
                <p><i class="fas fa-phone"></i> **Contact :** +33 1 11 22 33 44 (Standard)</p>
                <p><i class="fas fa-user-tag"></i> **Rôle :** Chirurgie, Chef de Service Adjoint</p>

                <div class="details">
                    <h4><i class="fas fa-clock"></i> Mes Heures d'Activité</h4>
                    <ul class="schedule-list">
                        <li>Lundi: <strong>8h00 - 16h00</strong></li>
                        <li>Mercredi: <strong>8h00 - 13h00</strong></li>
                        <li>Vendredi: <strong>14h00 - 18h00</strong> (Consultations externes)</li>
                    </ul>
                </div>

                <div class="location-actions">
                    <a href="#" class="btn primary-btn small-btn">Voir Patients Référés</a>
                    <a href="#" class="btn small-btn btn-refer">Référez un Patient <i class="fas fa-share"></i></a>
                </div>
            </div>
            
            <div class="location-card">
                <h3><i class="fas fa-clinic-medical"></i> Cabinet Médical Privé Dr. [Nom]</h3>
                <p><i class="fas fa-map-marker-alt"></i> **Adresse :** 45 Avenue de la République</p>
                <p><i class="fas fa-phone"></i> **Contact :** +33 6 78 90 12 34 (Secrétariat)</p>
                <p><i class="fas fa-user-tag"></i> **Rôle :** Pratique privée (Cardiologie)</p>

                <div class="details">
                    <h4><i class="fas fa-clock"></i> Mes Heures d'Activité</h4>
                    <ul class="schedule-list">
                        <li>Mardi: <strong>9h00 - 18h00</strong></li>
                        <li>Jeudi: <strong>9h00 - 18h00</strong></li>
                        <li>Samedi: <strong>9h00 - 12h00</strong> (Urgence légère)</li>
                    </ul>
                </div>

                <div class="location-actions">
                    <a href="#" class="btn primary-btn small-btn btn-schedule">Planifier un RDV <i class="fas fa-calendar-plus"></i></a>
                    <a href="#" class="btn small-btn btn-refer">Modifier les Horaires</a>
                </div>
            </div>

        </section>

        <a href="#" class="btn primary-btn btn-add" style="background-color: var(--color-medecin);"><i class="fas fa-plus"></i> Ajouter un Nouveau Lieu d'Exercice</a>
    </div>
</body>
</html>