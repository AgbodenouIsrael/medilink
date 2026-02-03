<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Hôpital - Medilink')</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>

<body class="dashboard-body hopital-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_hopital') }}"
                class="nav-item {{ Route::currentRouteName() == 'dashboard_hopital' ? 'active' : '' }}"><i
                    class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('liste_patients_hopital') }}"
                class="nav-item {{ Route::currentRouteName() == 'liste_patients_hopital' ? 'active' : '' }}"><i
                    class="fas fa-user-injured"></i>
                Patients Traités</a>
            <a href="{{ route('liste_medecins_hopital') }}"
                class="nav-item {{ Route::currentRouteName() == 'liste_medecins_hopital' ? 'active' : '' }}"><i
                    class="fas fa-user-md"></i> Médecins de
                l'Hôpital</a>
            <a href="{{ route('profil_hopital') }}"
                class="nav-item profile-link {{ Route::currentRouteName() == 'profil_hopital' ? 'active' : '' }}"><i
                    class="fas fa-user-circle"></i>
                Paramètres & Profil</a>
            <a href="{{ route('logout.hopital') }}" class="nav-item logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout.hopital') }}" method="POST" style="display: none;">
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