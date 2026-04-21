@extends('layouts.admin')

@section('title', 'Annuaire des Comptes - Admin')

@section('styles')
    <style>
        .entities-container {
            margin-top: 30px;
        }

        .entity-section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .entity-section h3 {
            color: var(--color-admin);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 2px solid #f5f5f5;
            padding-bottom: 15px;
        }

        .entity-table {
            width: 100%;
            border-collapse: collapse;
        }

        .entity-table th,
        .entity-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .entity-table th {
            background: #f8f9fa;
            font-size: 0.9em;
            text-transform: uppercase;
            color: #666;
        }

        .status-badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: 600;
        }

        .status-actif,
        .status-verifie,
        .status-valide {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-en_attente {
            background: #fff3e0;
            color: #ef6c00;
        }

        .doc-link {
            color: #007bff;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9em;
        }

        .doc-link:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Annuaire des Comptes</h2>
        <p>Gérez tous les professionnels et établissements enregistrés sur la plateforme.</p>
    </header>

    <div class="entities-container">
        <!-- Médecins -->
        <div class="entity-section">
            <h3><i class="fas fa-user-md"></i> Médecins</h3>
            <table class="entity-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Licence</th>
                        <th>Statut</th>
                        <th>Document</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($medecins as $medecin)
                        <tr>
                            <td>{{ $medecin->prenom }} {{ $medecin->nom }}</td>
                            <td>{{ $medecin->email }}</td>
                            <td>{{ $medecin->numero_licence }}</td>
                            <td><span class="status-badge status-{{ $medecin->statut }}">{{ $medecin->statut }}</span></td>
                            <td>
                                @if($medecin->certificat_path)
                                    <a href="{{ asset('storage/' . $medecin->certificat_path) }}" target="_blank" class="doc-link">
                                        <i class="fas fa-file-pdf"></i> Certificat
                                    </a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Hôpitaux -->
        <div class="entity-section">
            <h3><i class="fas fa-hospital"></i> Hôpitaux</h3>
            <table class="entity-table">
                <thead>
                    <tr>
                        <th>Nom de l'Établissement</th>
                        <th>Email</th>
                        <th>Zone</th>
                        <th>Statut</th>
                        <th>Document</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($hopitaux as $hopital)
                        <tr>
                            <td>{{ $hopital->nom }}</td>
                            <td>{{ $hopital->email }}</td>
                            <td>{{ $hopital->zone->nom ?? 'N/A' }}</td>
                            <td><span class="status-badge status-{{ $hopital->statut }}">{{ $hopital->statut }}</span></td>
                            <td>
                                @if($hopital->fichier_enregistrement_path)
                                    <a href="{{ asset('storage/' . $hopital->fichier_enregistrement_path) }}" target="_blank"
                                        class="doc-link">
                                        <i class="fas fa-file-pdf"></i> Enregistrement
                                    </a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pharmacies -->
        <div class="entity-section">
            <h3><i class="fas fa-pills"></i> Pharmacies</h3>
            <table class="entity-table">
                <thead>
                    <tr>
                        <th>Nom de l'Officine</th>
                        <th>Email</th>
                        <th>Licence</th>
                        <th>Statut</th>
                        <th>Document</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pharmacies as $pharmacie)
                        <tr>
                            <td>{{ $pharmacie->nom_officine }}</td>
                            <td>{{ $pharmacie->email }}</td>
                            <td>{{ $pharmacie->numero_licence }}</td>
                            <td><span class="status-badge status-{{ $pharmacie->statut }}">{{ $pharmacie->statut }}</span></td>
                            <td>
                                @if($pharmacie->fichier_licence_path)
                                    <a href="{{ asset('storage/' . $pharmacie->fichier_licence_path) }}" target="_blank"
                                        class="doc-link">
                                        <i class="fas fa-file-pdf"></i> Licence
                                    </a>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection