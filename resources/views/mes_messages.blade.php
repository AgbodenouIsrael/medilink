<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Messages - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }} ">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le Chat */
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
            background-color: #eaf1f7; /* Bleu très clair */
            border-left: 3px solid var(--color-patient);
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

        /* Message du Patient (Sortant) */
        .message-patient {
            float: right;
            background-color: var(--color-patient);
            color: white;
            border-bottom-right-radius: 2px;
        }

        /* Message du Médecin (Entrant) */
        .message-medecin {
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
            color: rgba(255, 255, 255, 0.7); /* Clair pour le fond bleu */
        }
        .message-medecin .message-time {
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
            background-color: var(--color-patient);
            color: white;
            border: none;
            border-radius: 50%;
            width: 45px;
            height: 45px;
            font-size: 1.2em;
        }
    </style>
</head>
<body class="dashboard-body patient-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_patient') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="{{ route('ma_fiche_medicale') }}" class="nav-item"><i class="fas fa-file-medical"></i> Dossier Médical</a>
            <a href="{{ route('trouver_pharmacie') }}" class="nav-item"><i class="fas fa-prescription-bottle-alt"></i> Pharmacies</a>
            <a href="#" class="nav-item active"><i class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}" class="nav-item"><i class="fas fa-hospital-alt"></i> Guide des Hôpitaux</a>
            <a href="{{ route('profil_patient') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Mon Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Messagerie Patient-Médecin</h2>
        </header>

        <div class="chat-container">
            <div class="conversation-list">
                <div class="conversation-item active">
                    <div class="avatar" style="background-color: var(--color-medecin);"><i class="fas fa-user-md"></i></div>
                    <div class="conv-info">
                        <strong>Dr. Martin Dubois</strong>
                        <small>Bonjour, concernant vos analyses...</small>
                    </div>
                </div>
                <div class="conversation-item">
                    <div class="avatar" style="background-color: #f44336;"><i class="fas fa-user-md"></i></div>
                    <div class="conv-info">
                        <strong>Dr. Sophie Leloup</strong>
                        <small>Merci pour l'ordonnance...</small>
                    </div>
                </div>
                <div class="conversation-item">
                    <div class="avatar" style="background-color: #9E9E9E;"><i class="fas fa-hospital"></i></div>
                    <div class="conv-info">
                        <strong>Hôpital Central</strong>
                        <small>Votre RDV est confirmé le 15/01.</small>
                    </div>
                </div>
            </div>

            <div class="chat-window">
                <div class="chat-header">
                    <h4>Discussion avec **Dr. Martin Dubois** (Généraliste)</h4>
                </div>

                <div class="messages">
                    <div class="message-bubble message-medecin">
                        Bonjour, j'ai bien reçu vos résultats d'analyses. Ils sont normaux. Comment vous sentez-vous ?
                        <span class="message-time">10:30</span>
                    </div>

                    <div class="message-bubble message-patient">
                        Bonjour Docteur, je me sens beaucoup mieux, merci. J'ai juste une petite douleur à la tête parfois.
                        <span class="message-time">10:32</span>
                    </div>
                    
                    <div class="message-bubble message-medecin">
                        D'accord. Pouvez-vous me donner plus de détails sur cette douleur ? Est-elle constante ?
                        <span class="message-time">10:35</span>
                    </div>

                </div>

                <div class="chat-input">
                    <input type="text" placeholder="Écrivez votre message ici...">
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>