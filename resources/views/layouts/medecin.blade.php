<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Professionnel - Medilink')</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>

<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}"
                class="nav-item {{ Route::currentRouteName() == 'dashboard_medecin' ? 'active' : '' }}"><i
                    class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('mes_patients') }}"
                class="nav-item {{ Route::currentRouteName() == 'mes_patients' ? 'active' : '' }}"><i
                    class="fas fa-users"></i> Liste des Patients</a>
            <a href="{{ route('messages_medecin') }}"
                class="nav-item {{ Route::currentRouteName() == 'messages_medecin' ? 'active' : '' }}"><i
                    class="fas fa-comments"></i> Messages
                (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}"
                class="nav-item {{ Route::currentRouteName() == 'mes_hopitaux_medecin' ? 'active' : '' }}"><i
                    class="fas fa-hospital-user"></i> Mes
                Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}"
                class="nav-item profile-link {{ Route::currentRouteName() == 'profil_medecin' ? 'active' : '' }}"><i
                    class="fas fa-user-circle"></i>
                Paramètres & Profil</a>
            <a href="{{ route('logout.medecin') }}" class="nav-item logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout.medecin') }}" method="POST" style="display: none;">
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