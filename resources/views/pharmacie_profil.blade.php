<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paramètres du Profil - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .profile-container { max-width: 1000px; margin: 0 auto; }
        .profile-header-card { 
            background: white; border-radius: 12px; border: 1px solid #eee; 
            padding: 30px; display: flex; align-items: center; gap: 25px; margin-bottom: 25px;
        }
        .profile-pic-large {
            width: 100px; height: 100px; background: #E8F5E9; color: var(--primary-green);
            border-radius: 15px; display: flex; align-items: center; justify-content: center;
            font-size: 2.5em; border: 1px solid #c8e6c9;
        }
        .settings-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
        .settings-card { background: white; border-radius: 12px; border: 1px solid #eee; padding: 25px; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 13px; color: #666; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;
        }
        
        .status-toggle {
            display: flex; justify-content: space-between; align-items: center;
            padding: 15px; background: #F8F9FA; border-radius: 8px; margin-top: 10px;
        }

        /* Switch style Readdy */
        .switch { position: relative; display: inline-block; width: 44px; height: 22px; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc; transition: .4s; border-radius: 34px;
        }
        .slider:before {
            position: absolute; content: ""; height: 18px; width: 18px; left: 2px; bottom: 2px;
            background-color: white; transition: .4s; border-radius: 50%;
        }
        input:checked + .slider { background-color: var(--primary-green); }
        input:checked + .slider:before { transform: translateX(22px); }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div style="padding: 25px;"><h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1></div>
        <nav class="nav-menu">
          <<a href="{{ route('dashboard_pharmacie') }}" class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="{{ route('pharmacie_prescriptions') }}" class="nav-item"><i class="fas fa-file-medical"></i>Prescription Digitale </a>
            <a href="{{ route('pharmacie_inventory') }}" class="nav-item"><i class="fas fa-boxes"></i> Inventaire</a>
            <a href="{{ route('pharmacie_sales') }}" class="nav-item"><i class="fas fa-cash-register"></i> Ventes / Point de vente</a>
            <a href="{{ route('pharmacie_profil') }}" class="nav-item"><i class="fas fa-user-cog"></i> Paramètres du profil</a>
        </nav>
    </aside>

    <main class="main-content">
        <div class="profile-container">
            <header style="margin-bottom:25px;">
                <h1 style="margin:0;">Pharmacy Profile</h1>
                <p style="color:#666;">Gérez vos informations publiques et vos paramètres opérationnels.</p>
            </header>

            <div class="profile-header-card">
                <div class="profile-pic-large"><i class="fas fa-clinic-medical"></i></div>
                <div style="flex-grow: 1;">
                    <h2 style="margin:0;">Pharmacie de la Gare</h2>
                    <p style="color:#666; margin:5px 0;">Lomé, Togo • ID: MED-TG-882</p>
                    <span style="background: #E8F5E9; color: #2E7D32; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600;">Verified Partner</span>
                </div>
                <button class="btn" style="background: var(--primary-green); color: white; border: none; padding: 12px 20px; border-radius: 8px; font-weight: 600;">Save Changes</button>
            </div>

            <div class="settings-grid">
                <div class="settings-card">
                    <h3>Informations Générales</h3>
                    <div class="form-group">
                        <label>Nom de la Pharmacie</label>
                        <input type="text" value="Pharmacie de la Gare">
                    </div>
                    <div class="form-group">
                        <label>Pharmacien en charge</label>
                        <input type="text" value="Dr. Kodjo Mensah">
                    </div>
                    <div class="form-group">
                        <label>Emplacement / Adresse</label>
                        <textarea rows="3">Avenue de la Libération, Face à la Gare Ferroviaire, Lomé, Togo</textarea>
                    </div>
                    <div class="form-group">
                        <label>Contact </label>
                        <input type="text" value="+228 90 00 00 00">
                    </div>
                </div>

                <div class="settings-card">
                    <h3>Visibilité et statut de l'application</h3>
                    <p style="font-size: 14px; color: #666; margin-bottom: 20px;">Contrôlez l'apparence de votre pharmacie pour les patients sur l'application Medilink.</p>
                    
                    <div class="status-toggle">
                        <div>
                            <strong>Accepter les ordonnances numériques</strong><br>
                            <small style="color:#888;">Autoriser les médecins à envoyer directement les ordonnances</small>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="status-toggle">
                        <div>
                            <strong>Indiquer le statut en ligne</strong><br>
                            <small style="color:#888;">Indiquer si la pharmacie est actuellement ouverte</small>
                        </div>
                        <label class="switch">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div class="status-toggle">
                        <div>
                            <strong>Synchronisation de l'inventaire</strong><br>
                            <small style="color:#888;">Afficher les niveaux de stock aux patients</small>
                        </div>
                        <label class="switch">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </div>

                    <div style="margin-top:25px;">
                        <label style="font-size: 13px; color: #666; font-weight: 600;">Heures d'ouverture</label>
                        <div style="display:flex; justify-content:space-between; margin-top:10px; font-size:14px;">
                            <span>Lundi - Vendredi</span>
                            <strong>08:00 - 21:00</strong>
                        </div>
                        <div style="display:flex; justify-content:space-between; margin-top:5px; font-size:14px;">
                            <span>Samedi</span>
                            <strong>08:00 - 18:00</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    </main>
    <script src="medilink_pharmacy.js"></script>
    </body>
</html>