<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard - Medilink Pharmacie')</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 20px;
            margin-bottom: 25px;
        }

        /* Common Layout Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            background: #f8f9fa;
            min-height: 100vh;
        }
    </style>
    @yield('styles')
</head>

<body>

    <aside class="sidebar">
        <div>
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_pharmacie') }}"
                class="nav-item {{ Route::currentRouteName() == 'dashboard_pharmacie' ? 'active' : '' }}"><i
                    class="fas fa-th-large"></i>
                Dashboard</a>
            <a href="{{ route('pharmacie_prescriptions') }}"
                class="nav-item {{ Route::currentRouteName() == 'pharmacie_prescriptions' ? 'active' : '' }}"><i
                    class="fas fa-file-medical"></i>Prescription Digitale </a>
            <a href="{{ route('pharmacie.inventory') }}"
                class="nav-item {{ Route::currentRouteName() == 'pharmacie.inventory' ? 'active' : '' }}"><i
                    class="fas fa-boxes"></i> Inventaire</a>
            <a href="{{ route('pharmacie_sales') }}"
                class="nav-item {{ Route::currentRouteName() == 'pharmacie_sales' ? 'active' : '' }}"><i
                    class="fas fa-cash-register"></i> Ventes /
                Point de vente</a>
            <a href="{{ route('pharmacie.history') }}"
                class="nav-item {{ Route::currentRouteName() == 'pharmacie.history' ? 'active' : '' }}"><i
                    class="fas fa-history"></i> Historique Ventes</a>
            <a href="{{ route('pharmacie.messages') }}"
                class="nav-item {{ Route::currentRouteName() == 'pharmacie.messages' ? 'active' : '' }}"><i
                    class="fas fa-comments"></i> Messages</a>
            <a href="{{ route('pharmacie_profil') }}"
                class="nav-item {{ Route::currentRouteName() == 'pharmacie_profil' ? 'active' : '' }}"><i
                    class="fas fa-user-cog"></i> Paramètres du
                profil</a>
            <a href="{{ route('logout.pharmacie') }}" class="nav-item logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Déconnexion
            </a>
            <form id="logout-form" action="{{ route('logout.pharmacie') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>
        <div class="user-profile" style="padding: 20px; border-top: 1px solid #eee;">
            <div style="display:flex; align-items:center;">
                <div
                    style="width:40px; height:40px; background:white; color:#FF6600; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:10px;">
                    {{ substr(Auth::guard('pharmacie')->user()->nom_officine ?? 'PH', 0, 2) }}
                </div>
                <div>
                    <strong>{{ Auth::guard('pharmacie')->user()->nom_officine ?? 'Pharmacie' }}</strong><br><small>{{ Auth::guard('pharmacie')->user()->ville ?? 'Lomé, Togo' }}</small>
                </div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        @if(session('success'))
            <div
                style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 20px; background: white; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div
                style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 20px; background: white; border-radius: 8px;">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="medilink_pharmacy.js"></script>
    @yield('scripts')
</body>

</html>