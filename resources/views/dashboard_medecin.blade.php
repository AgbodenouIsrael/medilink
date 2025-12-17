<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Professionnel - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="#" class="nav-item active"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('mes_patients') }}" class="nav-item"><i class="fas fa-users"></i> Liste des Patients</a>
            <a href="{{ route('messages_medecin') }}" class="nav-item"><i class="fas fa-comments"></i> Messages (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="nav-item"><i class="fas fa-hospital-user"></i> Mes Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Bienvenue Dr. [Nom du Médecin]</h2>
        </header>

        <section class="dashboard-grid">
            
            <div class="stat-card">
                <i class="fas fa-user-injured icon-large"></i>
                <h3>Vos Patients</h3>
                <p>Consultez la liste et l'historique de vos patients.</p>
                <a href="{{ route('mes_patients') }}" class="btn primary-btn small-btn">Voir la liste</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-envelope-open-text icon-large"></i>
                <h3>Messagerie</h3>
                <p>Chat en temps réel avec vos patients pour les suivis.</p>
                <a href="{{ route('messages_medecin') }}" class="btn primary-btn small-btn">Accéder au Chat</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-calendar-check icon-large"></i>
                <h3>Planification & Activité</h3>
                <p>Voir vos horaires et planifier de nouveaux rendez-vous.</p>
                <a href="{{ route('mes_hopitaux_medecin') }}" class="btn primary-btn small-btn">Gérer les RDV</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-cog icon-large"></i>
                <h3>Paramètres & Profil</h3>
                <p>Mettez à jour vos informations et votre certificat.</p>
                <a href="{{ route('profil_medecin') }}" class="btn primary-btn small-btn">Modifier le profil</a>
            </div>

        </section>
    </div>
</body>
</html>