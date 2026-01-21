<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande d'accès - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .form-card {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de
                Bord</a>
            <a href="{{ route('mes_patients') }}" class="nav-item active"><i class="fas fa-users"></i> Liste des
                Patients</a>
            <a href="{{ route('messages_medecin') }}" class="nav-item"><i class="fas fa-comments"></i> Messages
                (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="nav-item"><i class="fas fa-hospital-user"></i> Mes
                Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i>
                Paramètres & Profil</a>
            <a href="{{ route('logout.medecin') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
        <form id="logout-form" action="{{ route('logout.medecin') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Demander l'accès à un dossier</h2>
            <p>Le patient recevra une notification pour valider votre demande.</p>
        </header>

        <div class="form-card">
            @if(session('success'))
                <div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:15px;">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif
            @if ($errors->any())
                <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:15px;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('autorisations.store') }}" method="POST">
                @csrf

                <div class="input-group">
                    <label for="patient_email"><i class="fas fa-envelope"></i> Email du Patient</label>
                    <input id="patient_email" name="patient_email" type="email" required
                        placeholder="patient@exemple.com">
                </div>

                <div class="input-group">
                    <label for="type_acces"><i class="fas fa-key"></i> Type d'accès</label>
                    <select id="type_acces" name="type_acces"
                        style="width:100%; padding:10px; border-radius:5px; border:1px solid #ddd;">
                        <option value="lecture">Lecture Seule (Consultation)</option>
                        <option value="ecriture">Écriture (Ajout documents/ordonnances)</option>
                        <option value="complet" selected>Complet (Lecture + Écriture)</option>
                    </select>
                </div>

                <div class="input-group">
                    <label for="motif"><i class="fas fa-comment-medical"></i> Motif de la demande</label>
                    <textarea id="motif" name="motif" rows="3" required
                        placeholder="Ex: Suivi cardiologique régulier..."></textarea>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; margin-top:20px;">
                    <a href="{{ route('mes_patients') }}" style="color:#666; text-decoration:none;">Annuler</a>
                    <button type="submit" class="btn primary-btn"
                        style="background-color: var(--color-medecin);">Envoyer la demande</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>