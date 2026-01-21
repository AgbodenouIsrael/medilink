<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Hôpital - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="dashboard-body hopital-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="#" class="nav-item active"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('liste_patients_hopital') }}" class="nav-item"><i class="fas fa-user-injured"></i>
                Patients Traités</a>
            <a href="{{ route('liste_medecins_hopital') }}" class="nav-item"><i class="fas fa-user-md"></i> Médecins de
                l'Hôpital</a>
            <a href="{{ route('profil_hopital') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i>
                Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i>
                Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Bienvenue, {{ $hopital->nom }}</h2>
        </header>

        <section class="dashboard-grid">

            <div class="stat-card">
                <i class="fas fa-history icon-large"></i>
                <h3>Historique des Patients</h3>
                <p>Liste des patients ayant été traités dans votre établissement.</p>
                <a href="{{ route('liste_patients_hopital') }}" class="btn primary-btn small-btn">Voir l'historique</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-user-tie icon-large"></i>
                <h3>Personnel Médical</h3>
                <p>Liste et heures d'activité des médecins exerçant ici.</p>
                <a href="{{ route('liste_medecins_hopital') }}" class="btn primary-btn small-btn">Gérer les Médecins</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-cog icon-large"></i>
                <h3>Paramètres & Profil</h3>
                <p>Mettez à jour les informations de l'hôpital et les coordonnées.</p>
                <a href="{{ route('profil_hopital') }}" class="btn primary-btn small-btn">Modifier le profil</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-procedures icon-large"></i>
                <h3>Admissions en Cours</h3>
                <p>Statistiques et gestion des patients actuellement hospitalisés.</p>
                <a href="#"
                    onclick="alert('Cette fonctionnalité sera disponible prochainement. Elle permettra de gérer les admissions et hospitalisations en temps réel.'); return false;"
                    class="btn primary-btn small-btn">Voir les Admissions</a>
            </div>

        </section>
    </div>
</body>

</html>