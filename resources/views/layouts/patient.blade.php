<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Patient - Medilink')</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>

<body class="dashboard-body patient-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_patient') }}"
                class="nav-item {{ Route::currentRouteName() == 'dashboard_patient' ? 'active' : '' }}"><i
                    class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('ma_fiche_medicale') }}"
                class="nav-item {{ Route::currentRouteName() == 'ma_fiche_medicale' ? 'active' : '' }}"><i
                    class="fas fa-file-medical"></i> Dossier
                Médical</a>
            <a href="{{ route('autorisations.index') }}"
                class="nav-item {{ Route::currentRouteName() == 'autorisations.index' ? 'active' : '' }}"><i
                    class="fas fa-id-card-alt"></i> Mes
                Autorisations</a>
            <a href="{{ route('trouver_pharmacie') }}"
                class="nav-item {{ Route::currentRouteName() == 'trouver_pharmacie' ? 'active' : '' }}"><i
                    class="fas fa-prescription-bottle-alt"></i>
                Pharmacies</a>
            <a href="{{ route('mes_messages') }}"
                class="nav-item {{ Route::currentRouteName() == 'mes_messages' ? 'active' : '' }}"><i
                    class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}"
                class="nav-item {{ Route::currentRouteName() == 'guide_hopitaux' ? 'active' : '' }}"><i
                    class="fas fa-hospital-alt"></i> Guide des
                Hôpitaux</a>
            <a href="{{ route('profil') }}"
                class="nav-item profile-link {{ Route::currentRouteName() == 'profil' ? 'active' : '' }}"><i
                    class="fas fa-user-circle"></i> Mon
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
        @if(session('success'))
            <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    @yield('scripts')
</body>

</html>