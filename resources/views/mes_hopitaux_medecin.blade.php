<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Hôpitaux - MediLink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hopital-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .hopital-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 5px solid var(--color-medecin);
        }

        .hopital-card h4 {
            color: var(--color-medecin);
            margin-bottom: 5px;
            font-size: 1.2em;
        }

        .hopital-card p {
            color: #666;
            margin-bottom: 5px;
            font-size: 0.9em;
        }

        .table-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        th {
            color: #888;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
        }

        .btn-join {
            background: none;
            border: 2px solid var(--color-medecin);
            color: var(--color-medecin);
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-join:hover {
            background: var(--color-medecin);
            color: white;
        }
    </style>
</head>

<body class="dashboard-body medecin-theme">
    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_medecin') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de
                Bord</a>
            <a href="{{ route('mes_patients') }}" class="nav-item"><i class="fas fa-users"></i> Liste des Patients</a>
            <a href="{{ route('messages_medecin') }}" class="nav-item"><i class="fas fa-comments"></i> Messages
                (Chat)</a>
            <a href="{{ route('mes_hopitaux_medecin') }}" class="nav-item active"><i class="fas fa-hospital-user"></i>
                Mes Hôpitaux/Cabinets</a>
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
            <h2>Gestion des Hôpitaux & Cabinets</h2>
            <p>Gérez vos affiliations aux établissements de santé.</p>
        </header>

        @if(session('success'))
            <div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <h3 style="margin-bottom: 15px; color: #444;">Vos lieux d'exercice actuels</h3>

        @if($hopitaux->isEmpty())
            <div style="background:#fff3cd; color:#856404; padding:15px; border-radius:6px; margin-bottom:30px;">
                Vous n'êtes affilié à aucun établissement pour le moment.
            </div>
        @else
            <div class="hopital-grid">
                @foreach($hopitaux as $hopital)
                    <div class="hopital-card">
                        <h4><i class="fas fa-clinic-medical"></i> {{ $hopital->nom }}</h4>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $hopital->ville }}</p>
                        <p><strong>Rôle:</strong> {{ $hopital->pivot->role ?? 'Non défini' }}</p>
                        <span
                            style="display:inline-block; margin-top:10px; padding:3px 8px; border-radius:12px; font-size:0.8em; background:#e8f5e9; color:var(--color-medecin);">
                            {{ $hopital->pivot->statut ?? 'Actif' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="table-card">
            <h3 style="margin-bottom: 15px; color: #444;">Rejoindre un établissement disponible</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nom de l'établissement</th>
                        <th>Ville / Adresse</th>
                        <th>Contact</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($allHopitaux as $h)
                        @if(!$hopitaux->contains($h->id))
                            <tr>
                                <td><strong>{{ $h->nom }}</strong></td>
                                <td>{{ $h->ville }}</td>
                                <td>{{ $h->contact }}</td>
                                <td>
                                    <form action="{{ route('hopitaux.join') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="hopital_id" value="{{ $h->id }}">
                                        <button type="submit" class="btn-join">Rejoindre</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>