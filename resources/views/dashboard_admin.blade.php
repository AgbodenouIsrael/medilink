<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body class="dashboard-body admin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink <span
                style="font-size:0.5em; display:block; text-align:center; color:#666;">ADMIN</span></h1>
        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}" class="nav-item active"><i class="fas fa-tachometer-alt"></i> Vue
                d'ensemble</a>
            <a href="{{ route('admin.validations') }}" class="nav-item">
                <i class="fas fa-check-double"></i> Validations
                <span
                    style="background:white; color:var(--color-admin); padding:2px 6px; border-radius:10px; font-size:0.7em; margin-left:5px;">{{ $stats['pending'] ?? 0 }}</span>
            </a>
            {{-- <a href="#" class="nav-item"><i class="fas fa-users"></i> Tous les Utilisateurs</a> --}}
            <a href="#" class="nav-item"><i class="fas fa-cogs"></i> Paramètres Plateforme</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i>
                Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Administration Générale</h2>
            <p>Supervision de la plateforme et gestion des nouveaux inscrits.</p>
        </header>

        <div class="dashboard-grid">
            <div class="stat-card">
                <i class="fas fa-user-md icon-large"></i>
                <h3>{{ $stats['medecins'] ?? 0 }}</h3>
                <p>Médecins Inscrits</p>
                {{-- <small class="text-success">+5 cette semaine</small> --}}
            </div>

            <div class="stat-card">
                <i class="fas fa-user-injured icon-large"></i>
                <h3>{{ $stats['patients'] ?? 0 }}</h3>
                <p>Patients Actifs</p>
                {{-- <small class="text-success">+120 nouveaux</small> --}}
            </div>

            <div class="stat-card">
                <i class="fas fa-hospital icon-large"></i>
                <h3>{{ $stats['hopitaux'] ?? 0 }}</h3>
                <p>Hôpitaux Partenaires</p>
            </div>

            <div class="stat-card" style="border: 2px solid var(--color-admin);">
                <i class="fas fa-exclamation-circle icon-large"></i>
                <h3>{{ $stats['pending'] ?? 0 }}</h3>
                <p>Comptes en Attente</p>
                <a href="{{ route('admin.validations') }}" class="btn small-btn primary-btn"
                    style="background-color: var(--color-admin);">Examiner</a>
            </div>
        </div>

        <section style="margin-top: 40px;">
            <h3>Dernières Activités de la Plateforme</h3>
            <div class="settings-card" style="margin-top: 20px;">
                <ul class="action-list">
                    @forelse($activities as $activity)
                        <li>
                            <a href="#">
                                <i class="{{ $activity->icon }}"></i> {{ $activity->description }}
                                <span
                                    style="margin-left:auto; font-size:0.8em; color:#888;">{{ $activity->created_at->diffForHumans() }}</span>
                            </a>
                        </li>
                    @empty
                        <li>
                            <a href="#">
                                <i class="fas fa-info-circle"></i> Aucune activité récente.
                            </a>
                        </li>
                    @endforelse
                </ul>
            </div>
        </section>
    </div>
</body>

</html>