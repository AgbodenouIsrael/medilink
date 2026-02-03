<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Medilink')</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>

<body class="dashboard-body admin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink <span
                style="font-size:0.5em; display:block; text-align:center; color:#666;">ADMIN</span></h1>
        <nav class="nav-menu">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-item {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}"><i
                    class="fas fa-tachometer-alt"></i> Vue
                d'ensemble</a>
            <a href="{{ route('admin.validations') }}"
                class="nav-item {{ Route::currentRouteName() == 'admin.validations' ? 'active' : '' }}">
                <i class="fas fa-check-double"></i> Validations
                <span
                    style="background:white; color:var(--color-admin); padding:2px 6px; border-radius:10px; font-size:0.7em; margin-left:5px;">{{ $pending_count ?? 0 }}</span>
            </a>
            <a href="#" class="nav-item"><i class="fas fa-cogs"></i> Paramètres Plateforme</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i>
                Déconnexion</a>
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