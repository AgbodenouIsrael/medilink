<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Messages - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le Chat */
        .chat-container {
            display: flex;
            background-color: var(--color-card-background);
            height: calc(100vh - 150px);
            /* Ajuster la hauteur de la fenêtre de chat */
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
            background-color: #eaf1f7;
            /* Bleu très clair */
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
            background-color: var(--color-background);
            /* Léger fond pour le corps du chat */
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
            color: rgba(255, 255, 255, 0.7);
            /* Clair pour le fond bleu */
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
            <a href="{{ route('dashboard_patient') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de
                Bord</a>
            <a href="{{ route('ma_fiche_medicale') }}" class="nav-item"><i class="fas fa-file-medical"></i> Dossier
                Médical</a>
            <a href="{{ route('trouver_pharmacie') }}" class="nav-item"><i class="fas fa-prescription-bottle-alt"></i>
                Pharmacies</a>
            <a href="#" class="nav-item active"><i class="fas fa-comments"></i> Mes Messages</a>
            <a href="{{ route('guide_hopitaux') }}" class="nav-item"><i class="fas fa-hospital-alt"></i> Guide des
                Hôpitaux</a>
            <a href="{{ route('profil') }}" class="nav-item profile-link"><i class="fas fa-user-circle"></i> Mon
                Profil</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i>
                Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Messagerie Patient-Médecin</h2>
        </header>

        <div class="chat-container">
            <div class="conversation-list">
                @forelse($chats as $c)
                    <div class="conversation-item {{ isset($chat) && $chat->id == $c->id ? 'active' : '' }}"
                        onclick="window.location='{{ route('mes_messages.show', $c->id) }}'">
                        <div class="avatar" style="background-color: var(--color-medecin);"><i class="fas fa-user-md"></i>
                        </div>
                        <div class="conv-info">
                            <strong>{{ $c->medecin->prenom }} {{ $c->medecin->nom }}</strong>
                            <small>{{ $c->messages->last() ? Str::limit($c->messages->last()->contenu, 30) : 'Aucun message' }}</small>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-gray-500">Aucune conversation active.</div>
                @endforelse
            </div>

            <div class="chat-window">
                @if(isset($chat))
                    <div class="chat-header">
                        <h4>Discussion avec **Dr. {{ $chat->medecin->prenom }} {{ $chat->medecin->nom }}**</h4>
                    </div>

                    <div class="messages" id="messages-container">
                        @foreach($chat->messages as $msg)
                            @php
                                $isMe = ($msg->expediteur_type === get_class($user) && $msg->expediteur_id === $user->id);
                            @endphp
                            <div class="message-bubble {{ $isMe ? 'message-patient' : 'message-medecin' }}">
                                {{ $msg->contenu }}
                                <span class="message-time">{{ $msg->created_at->format('H:i') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="chat-input">
                        <form action="{{ route('patient.messages.store', $chat->id) }}" method="POST"
                            style="display:flex; width:100%; gap:10px;">
                            @csrf
                            <input type="text" name="contenu" placeholder="Écrivez votre message ici..." required
                                autocomplete="off">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center justify-center h-full text-gray-500">
                        Sélectionnez une conversation.
                    </div>
                @endif
            </div>
        </div>
        <script>
            // Scroll to bottom
            const container = document.getElementById('messages-container');
            if (container) container.scrollTop = container.scrollHeight;
        </script>
    </div>
</body>

</html>