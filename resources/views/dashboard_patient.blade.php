<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Patient - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="dashboard-body patient-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="#" class="nav-item active"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('ma_fiche_medicale') }}" class="nav-item"><i class="fas fa-file-medical"></i> Dossier
                Médical</a>
            <a href="{{ route('autorisations.index') }}" class="nav-item"><i class="fas fa-id-card-alt"></i> Mes
                Autorisations</a>
            <a href="{{ route('trouver_pharmacie') }}" class="nav-item"><i class="fas fa-prescription-bottle-alt"></i>
                Pharmacies</a>
            <a href="{{ route('mes_messages') }}" class="nav-item"><i class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}" class="nav-item"><i class="fas fa-hospital-alt"></i> Guide des
                Hôpitaux</a>
            <a href="{{ route('profil') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Mon
                Profil</a>
            <a href="{{ route('logout.patient') }}" class="nav-item logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>

            <form id="logout-form" action="{{ route('logout.patient') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>
                @if(Auth::guard('patient')->check())
                    Bienvenue, {{ Auth::guard('patient')->user()->prenom }} {{ Auth::guard('patient')->user()->nom }}
                @else
                    Bienvenue, Patient (Non connecté)
                @endif
            </h2>
        </header>

        @if (session('success'))
            <div style="color: green; padding: 10px; border: 1px solid green;">
                {{ session('success') }}
            </div>
        @endif

        <section class="dashboard-grid">

            <div class="stat-card">
                <i class="fas fa-file-medical icon-large"></i>
                <h3>Dossier Médical</h3>
                <p>Consultez vos antécédents et traitements.</p>
                <a href="{{ route('ma_fiche_medicale') }}" class="btn primary-btn small-btn">Ma Fiche Médicale</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-id-card-alt icon-large"></i>
                <h3>Autorisations d'Accès</h3>
                <p>Gérez qui peut voir votre dossier médical.</p>
                <a href="{{ route('autorisations.index') }}" class="btn primary-btn small-btn">Gérer les accès</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-search-location icon-large"></i>
                <h3>Trouver une Pharmacie</h3>
                <p>Recherchez les pharmacies de votre zone par médicament.</p>
                <a href="{{ route('trouver_pharmacie') }}" class="btn primary-btn small-btn">Rechercher</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-inbox icon-large"></i>
                <h3>Mes Messages</h3>
                <p>Discutez en temps réel avec vos médecins.</p>
                <a href="{{ route('mes_messages') }}" class="btn primary-btn small-btn">Voir les messages</a>
            </div>

            <div class="stat-card">
                <i class="fas fa-map-marked-alt icon-large"></i>
                <h3>Guide des Hôpitaux</h3>
                <p>Trouvez un centre de santé et demandez un rendez-vous.</p>
                <a href="{{ route('guide_hopitaux') }}" class="btn primary-btn small-btn">Voir la carte</a>
            </div>

        </section>
    </div>
</body>

</html>