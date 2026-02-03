@extends('layouts.medecin')

@section('title', 'Mes Hôpitaux - MediLink')

@section('styles')
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
            border-left: 5px solid #2e7d32;
            /* var(--color-medecin) */
        }

        .hopital-card h4 {
            color: #2e7d32;
            /* var(--color-medecin) */
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
            border: 2px solid #2e7d32;
            /* var(--color-medecin) */
            color: #2e7d32;
            /* var(--color-medecin) */
            padding: 5px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-join:hover {
            background: #2e7d32;
            /* var(--color-medecin) */
            color: white;
        }
    </style>
@endsection

@section('content')
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
                        style="display:inline-block; margin-top:10px; padding:3px 8px; border-radius:12px; font-size:0.8em; background:#e8f5e9; color:#2e7d32;">
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
@endsection