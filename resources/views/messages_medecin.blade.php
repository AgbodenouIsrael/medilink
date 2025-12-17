<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - Dashboard Médecin - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le Chat (Adapté au Thème Médecin) */
        .chat-container {
            display: flex;
            background-color: var(--color-card-background);
            height: calc(100vh - 150px); /* Ajuster la hauteur de la fenêtre de chat */
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        /* Liste des Conversations */
        .conversation-list {
            flex-basis: 300px;
            border-right: 1px solid var(--color-border);
            overflow-y: auto;
        }
        
        .conversation-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .conversation-item:hover {
            background-color: #f7f7f7;
        }

        .conversation-item.active {
            background-color: #eaf7ed; /* Vert très clair pour l'actif */
            border-left: 3px solid var(--color-medecin);
        }

        .avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #ccc;
            margin-right: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5em;
            color: white;
            flex-shrink: 0;
        }
        
        .conv-info strong {
            display: block;
            font-size: 1em;
            color: var(--color-text);
        }

        .conv-info small {
            color: #777;
            font-size: 0.8em;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Fenêtre de Chat Active */
        .chat-window {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 15px;
            border-bottom: 1px solid var(--color-border);
            background-color: #fcfcfc;
        }
        
        .chat-header h4 {
            color: var(--color-medecin); /* Titre en Vert */
        }

        .messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            background-color: var(--color-background); /* Léger fond pour le corps du chat */
        }

        .message-bubble {
            max-width: 70%;
            padding: 10px 15px;
            border-radius: 18px;
            margin-bottom: 10px;
            clear: both;
            line-height: 1.4;
        }

        /* Message du Médecin (Sortant) - **Thème Vert** */
        .message-medecin-out {
            float: right;
            background-color: var(--color-medecin);
            color: white;
            border-bottom-right-radius: 2px;
        }

        /* Message du Patient (Entrant) */
        .message-patient-in {
            float: left;
            background-color: #e9e9e9;
            color: var(--color-text);
            border-bottom-left-radius: 2px;
        }

        .message-time {
            display: block;
            font-size: 0.7em;
            margin-top: 5px;
            text-align: right;
            color: rgba(255, 255, 255, 0.7); /* Clair pour le fond vert */
        }
        .message-patient-in .message-time {
             color: #777;
        }

        /* Formulaire d'Envoi */
        .chat-input {
            padding: 15px;
            border-top: 1px solid var(--color-border);
            display: flex;
            gap: 10px;
        }

        .chat-input input[type="text"] {
            flex-grow: 1;
            padding: 12px;
            border-radius: 25px;
            border: 1px solid var(--color-border);
        }

        .chat-input button {
            background-color: var(--color-medecin);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            font-size: 1.2em;
        }
    </style>
</head>
<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('mes_patients') }}" class="nav-item"><i class="fas fa-users"></i> Liste des Patients</a>
            <a href="#" class="nav-item active"><i class="fas fa-comments"></i> Messages (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="nav-item"><i class="fas fa-hospital-user"></i> Mes Hôpitaux/Cabinets</a>
            <a href="{{ route('profil_medecin') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Paramètres & Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Messagerie Professionnelle</h2>
            <p>Communiquez avec vos patients et les autres établissements.</p>
        </header>

        <div class="chat-container">
            <div class="conversation-list">
                <div class="conversation-item active">
                    <div class="avatar" style="background-color: var(--color-patient);"><i class="fas fa-user-injured"></i></div>
                    <div class="conv-info">
                        <strong>Jean Dupont (P0012)</strong>
                        <small>Je me sens beaucoup mieux, merci...</small>
                    </div>
                </div>
                <div class="conversation-item">
                    <div class="avatar" style="background-color: var(--color-hopital);"><i class="fas fa-hospital"></i></div>
                    <div class="conv-info">
                        <strong>Hôpital Central</strong>
                        <small>Transfert du dossier de Mme. Camara...</small>
                    </div>
                </div>
                <div class="conversation-item">
                    <div class="avatar" style="background-color: #3f51b5;"><i class="fas fa-user-injured"></i></div>
                    <div class="conv-info">
                        <strong>Fatou Camara (P0045)</strong>
                        <small>J'ai une question sur mon traitement.</small>
                    </div>
                </div>
            </div>

            <div class="chat-window">
                <div class="chat-header">
                    <h4>Discussion avec **Jean Dupont** (Patient)</h4>
                </div>

                <div class="messages">
                    <div class="message-bubble message-patient-in">
                        Bonjour Docteur, je me sens beaucoup mieux, merci. J'ai juste une petite douleur à la tête parfois.
                        <span class="message-time">10:32</span>
                    </div>
                    
                    <div class="message-bubble message-medecin-out">
                        Bonjour Jean, c'est une excellente nouvelle. D'accord. Pouvez-vous me donner plus de détails sur cette douleur ? Est-elle constante ?
                        <span class="message-time">10:35</span>
                    </div>
                    
                    <div class="message-bubble message-patient-in">
                        Elle vient et part, surtout le soir après le travail. Je prends du Paracétamol.
                        <span class="message-time">10:40</span>
                    </div>

                    <div class="message-bubble message-medecin-out">
                        C'est noté. Je vous conseille de noter l'intensité sur 3 jours, et si ça ne passe pas, venez me voir en consultation la semaine prochaine.
                        <span class="message-time">10:45</span>
                    </div>

                </div>

                <div class="chat-input">
                    <input type="text" placeholder="Écrivez votre réponse ici...">
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>