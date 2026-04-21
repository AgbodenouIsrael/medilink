@extends('layouts.admin')

@section('title', 'Validation Comptes - Admin - Medilink')

@section('styles')
    <style>
        .validation-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .validation-table th,
        .validation-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .validation-table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .btn-action {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 32px;
            height: 32px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            color: white;
            text-decoration: none;
        }

        .btn-validate {
            background-color: #28a745;
        }

        .btn-reject {
            background-color: #dc3545;
        }

        .btn-view {
            background-color: #17a2b8;
        }

        .badge-pending {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.8em;
            font-weight: bold;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Demandes de Validation</h2>
        <p>Vérifiez les documents légaux des professionnels avant activation.</p>
    </header>

    @if(session('success'))
        <div style="background:#d4edda; color:#155724; padding:15px; margin-bottom:20px; border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    <table class="validation-table">
        <thead>
            <tr>
                <th>Nom / Établissement</th>
                <th>Type</th>
                <th>Date Inscription</th>
                <th>Documents</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Médecins -->
            @foreach($pendingMedecins as $medecin)
                <tr>
                    <td>
                        <strong>Dr. {{ $medecin->prenom }} {{ $medecin->nom }}</strong><br>
                        <small>{{ $medecin->email }}</small><br>
                        <small>Licence: {{ $medecin->numero_licence }}</small>
                    </td>
                    <td><span class="badge-pending" style="background:#e8f5e9; color:#2e7d32;">Médecin</span></td>
                    <td>{{ $medecin->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($medecin->certificat_path)
                            <a href="{{ asset('storage/' . $medecin->certificat_path) }}" target="_blank"
                                style="text-decoration:underline; color:#007bff;">
                                <i class="fas fa-file-pdf"></i> Certificat
                            </a>
                        @else
                            <span class="text-gray-500">Aucun fichier</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.approve') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="medecin">
                            <input type="hidden" name="id" value="{{ $medecin->id }}">
                            <button type="submit" class="btn-action btn-validate" title="Valider"
                                onclick="return confirm('Valider ce compte médecin ?')">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>

                        <form action="{{ route('admin.reject') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="medecin">
                            <input type="hidden" name="id" value="{{ $medecin->id }}">
                            <button type="submit" class="btn-action btn-reject" title="Rejeter et Supprimer"
                                onclick="return confirm('Rejeter et supprimer ce compte ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            <!-- Hôpitaux -->
            @foreach($pendingHopitaux as $hopital)
                <tr>
                    <td>
                        <strong>{{ $hopital->nom }}</strong><br>
                        <small>{{ $hopital->email }}</small><br>
                        <small>Zone: {{ $hopital->zone->nom ?? 'N/A' }}</small>
                    </td>
                    <td><span class="badge-pending" style="background:#f3e5f5; color:#7b1fa2;">Hôpital</span></td>
                    <td>{{ $hopital->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($hopital->fichier_enregistrement_path)
                            <a href="{{ asset('storage/' . $hopital->fichier_enregistrement_path) }}" target="_blank"
                                style="text-decoration:underline; color:#007bff;">
                                <i class="fas fa-file-pdf"></i> Document Légal
                            </a>
                        @else
                            <span class="text-gray-500">Aucun fichier</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.approve') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="hopital">
                            <input type="hidden" name="id" value="{{ $hopital->id }}">
                            <button type="submit" class="btn-action btn-validate" title="Valider"
                                onclick="return confirm('Valider cet établissement ?')">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>

                        <form action="{{ route('admin.reject') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="hopital">
                            <input type="hidden" name="id" value="{{ $hopital->id }}">
                            <button type="submit" class="btn-action btn-reject" title="Rejeter et Supprimer"
                                onclick="return confirm('Rejeter et supprimer cet établissement ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            <!-- Pharmacies -->
            @foreach($pendingPharmacies as $pharmacie)
                <tr>
                    <td>
                        <strong>{{ $pharmacie->nom_officine }}</strong><br>
                        <small>{{ $pharmacie->email }}</small><br>
                        <small>Licence: {{ $pharmacie->numero_licence }}</small>
                    </td>
                    <td><span class="badge-pending" style="background:#fff3e0; color:#ef6c00;">Pharmacie</span></td>
                    <td>{{ $pharmacie->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if($pharmacie->fichier_licence_path)
                            <a href="{{ asset('storage/' . $pharmacie->fichier_licence_path) }}" target="_blank"
                                style="text-decoration:underline; color:#007bff;">
                                <i class="fas fa-file-pdf"></i> Licence/Agrément
                            </a>
                        @else
                            <span class="text-gray-500">Validation manuelle (Licence)</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('admin.approve') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="pharmacie">
                            <input type="hidden" name="id" value="{{ $pharmacie->id }}">
                            <button type="submit" class="btn-action btn-validate" title="Valider"
                                onclick="return confirm('Valider cette pharmacie ?')">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>

                        <form action="{{ route('admin.reject') }}" method="POST" style="display:inline;">
                            @csrf
                            <input type="hidden" name="type" value="pharmacie">
                            <input type="hidden" name="id" value="{{ $pharmacie->id }}">
                            <button type="submit" class="btn-action btn-reject" title="Rejeter et Supprimer"
                                onclick="return confirm('Rejeter et supprimer cette pharmacie ?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($pendingMedecins->isEmpty() && $pendingHopitaux->isEmpty() && $pendingPharmacies->isEmpty())
                <tr>
                    <td colspan="5" style="text-align:center; padding:30px; color:#777;">
                        Aucune demande en attente.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection