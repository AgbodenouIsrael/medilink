<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Paramètres du Profil - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .profile-header-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 25px;
        }

        .profile-pic-large {
            width: 100px;
            height: 100px;
            background: #FFF3E0;
            color: #FF6600;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5em;
            border: 1px solid #ffe0b2;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        .settings-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-family: inherit;
        }

        .status-toggle {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #F8F9FA;
            border-radius: 8px;
            margin-top: 10px;
        }

        /* Switch style Readdy */
        .switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #FF6600;
        }

        input:checked+.slider:before {
            transform: translateX(22px);
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div style="padding: 25px;">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_pharmacie') }}" class="nav-item"><i class="fas fa-th-large"></i>
                Dashboard</a>
            <a href="{{ route('pharmacie_prescriptions') }}" class="nav-item"><i
                    class="fas fa-file-medical"></i>Prescription Digitale </a>
            <a href="{{ route('pharmacie.inventory') }}" class="nav-item"><i class="fas fa-boxes"></i>
                Inventaire</a>
            <a href="{{ route('pharmacie_sales') }}" class="nav-item"><i class="fas fa-cash-register"></i> Ventes /
                Point de vente</a>
            <a href="{{ route('pharmacie.history') }}" class="nav-item"><i class="fas fa-history"></i> Historique
                Ventes</a>
            <a href="{{ route('pharmacie.messages') }}" class="nav-item"><i class="fas fa-comments"></i> Messages</a>
            <a href="{{ route('pharmacie_profil') }}" class="nav-item active"><i class="fas fa-user-cog"></i> Paramètres
                du
                profil</a>
        </nav>
    </aside>

    <main class="main-content">
        @if(session('success'))
            <div style="background:#d4edda;color:#155724;padding:15px;border-radius:8px;margin-bottom:20px;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div style="background:#f8d7da;color:#721c24;padding:15px;border-radius:8px;margin-bottom:20px;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="profile-container">
            <header style="margin-bottom:25px;">
                <h1 style="margin:0;">Pharmacy Profile</h1>
                <p style="color:#666;">Gérez vos informations publiques et vos paramètres opérationnels.</p>
            </header>

            <form action="{{ route('pharmacie.update_profil') }}" method="POST">
                @csrf
                <div class="profile-header-card">
                    <div class="profile-pic-large"><i class="fas fa-clinic-medical"></i></div>
                    <div style="flex-grow: 1;">
                        <h2 style="margin:0;">{{ $pharmacie->nom_officine }}</h2>
                        <p style="color:#666; margin:5px 0;">{{ $pharmacie->zone->ville ?? 'Lomé' }},
                            {{ $pharmacie->zone->nom ?? 'Togo' }} • ID: {{ $pharmacie->numero_licence }}
                        </p>
                        <span
                            style="background: #E8F5E9; color: #2E7D32; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">{{ ucfirst($pharmacie->statut) }}
                            Partner</span>
                    </div>
                    <button type="submit" class="btn"
                        style="background: #FF6600; color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;">Enregistrer
                        les modifications</button>
                </div>

                <div class="settings-grid">
                    <div class="settings-card">
                        <h3>Informations Générales</h3>
                        <div class="form-group">
                            <label>Nom de la Pharmacie</label>
                            <input type="text" name="nom_officine"
                                value="{{ old('nom_officine', $pharmacie->nom_officine) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Pharmacien en charge</label>
                            <input type="text" name="pharmacien_titulaire"
                                value="{{ old('pharmacien_titulaire', $pharmacie->pharmacien_titulaire) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Emplacement / Adresse</label>
                            <textarea name="adresse_complete" rows="3"
                                required>{{ old('adresse_complete', $pharmacie->adresse_complete) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Contact </label>
                            <input type="text" name="telephone" value="{{ old('telephone', $pharmacie->telephone) }}"
                                required>
                        </div>
                    </div>

                    <div class="settings-card">
                        <h3>Visibilité et statut de l'application</h3>
                        <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Contrôlez l'apparence de votre
                            pharmacie pour les patients sur l'application Medilink.</p>

                        <div class="status-toggle">
                            <div>
                                <strong>Accepter les ordonnances numériques</strong><br>
                                <small style="color:#888;">Autoriser les médecins à envoyer directement les
                                    ordonnances</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="accepte_ordonnances" {{ $pharmacie->accepte_ordonnances ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="status-toggle">
                            <div>
                                <strong>Indiquer le statut en ligne</strong><br>
                                <small style="color:#888;">Indiquer si la pharmacie est actuellement ouverte</small>
                            </div>
                            <label class="switch">
                                <input type="checkbox" name="en_ligne" {{ $pharmacie->en_ligne ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </div>

                        @php
                            $horaires = $pharmacie->horaires_ouverture ?? [];
                            $lv = $horaires['lundi_vendredi'] ?? '08:00 - 21:00';
                            $sa = $horaires['samedi'] ?? '08:00 - 18:00';

                            $lv_parts = explode(' - ', $lv);
                            $sa_parts = explode(' - ', $sa);

                            $lv_start = isset($lv_parts[0]) ? trim($lv_parts[0]) : '08:00';
                            $lv_end = isset($lv_parts[1]) ? trim($lv_parts[1]) : '21:00';

                            $sa_start = isset($sa_parts[0]) ? trim($sa_parts[0]) : '08:00';
                            $sa_end = isset($sa_parts[1]) ? trim($sa_parts[1]) : '18:00';
                        @endphp

                        <div style="margin-top:25px;">
                            <label style="font-size: 13px; color: #666; font-weight: 600;">Heures d'ouverture</label>

                            <div style="margin-top:15px;">
                                <div style="font-size:14px; margin-bottom:5px;">Lundi - Vendredi</div>
                                <div style="display:flex; gap:10px; align-items:center;">
                                    <input type="time" name="horaires_lv_start" value="{{ $lv_start }}">
                                    <span>à</span>
                                    <input type="time" name="horaires_lv_end" value="{{ $lv_end }}">
                                </div>
                            </div>

                            <div style="margin-top:15px;">
                                <div style="font-size:14px; margin-bottom:5px;">Samedi</div>
                                <div style="display:flex; gap:10px; align-items:center;">
                                    <input type="time" name="horaires_sa_start" value="{{ $sa_start }}">
                                    <span>à</span>
                                    <input type="time" name="horaires_sa_end" value="{{ $sa_end }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="medilink_pharmacy.js"></script>
</body>

</html>