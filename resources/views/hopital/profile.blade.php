@extends('layouts.hopital')

@section('title', 'Profil Hôpital - MediLink')

@section('styles')
    <style>
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--color-card-background);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .profile-header h3 {
            color: var(--color-hopital);
            margin-top: 10px;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .settings-card {
            background-color: var(--color-card-background);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .settings-card h3 {
            color: var(--color-hopital);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--color-border);
            font-size: 1.4em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-row {
            margin-bottom: 15px;
            padding: 10px;
            border-left: 3px solid var(--color-hopital);
            background: #f9f9f9;
        }

        .info-row strong {
            color: #555;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            display: inline-block;
            margin-top: 5px;
        }

        .status-verified {
            background-color: #e8f5e9;
            color: #28a745;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #ffc107;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Profil de l'Établissement</h2>
        <p>Gérez les informations de votre hôpital/clinique.</p>
    </header>

    <div class="profile-header">
        <i class="fas fa-hospital-user" style="font-size: 4em; color: var(--color-hopital);"></i>
        <h3>{{ $hopital->nom }}</h3>
        <p style="font-size: 1.1em; color: #555;">Inscrit depuis le {{ $hopital->created_at->format('d/m/Y') }}</p>
    </div>

    <section class="profile-grid">
        <div class="settings-card">
            <h3><i class="fas fa-info-circle"></i> Informations de l'Établissement</h3>

            <form action="{{ route('hopital.update_profil') }}" method="POST">
                @csrf
                <div class="info-row" style="background: transparent; border: none; padding: 0; margin-bottom: 20px;">
                    <label for="nom" style="display: block; font-weight: bold; margin-bottom: 5px;">Nom de l'Établissement :</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $hopital->nom) }}" 
                        style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 5px;">
                    @error('nom') <span class="error-msg" style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>

                <div class="info-row" style="background: transparent; border: none; padding: 0; margin-bottom: 20px;">
                    <label for="email" style="display: block; font-weight: bold; margin-bottom: 5px;">Email Institutionnel :</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $hopital->email) }}" 
                        style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 5px;">
                    @error('email') <span class="error-msg" style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>

                <div class="info-row" style="background: transparent; border: none; padding: 0; margin-bottom: 20px;">
                    <label for="contact" style="display: block; font-weight: bold; margin-bottom: 5px;">Contact :</label>
                    <input type="text" id="contact" name="contact" value="{{ old('contact', $hopital->contact) }}" 
                        style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 5px;">
                    @error('contact') <span class="error-msg" style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>

                <div class="info-row" style="background: transparent; border: none; padding: 0; margin-bottom: 20px;">
                    <label for="adresse" style="display: block; font-weight: bold; margin-bottom: 5px;">Adresse :</label>
                    <input type="text" id="adresse" name="adresse" value="{{ old('adresse', $hopital->adresse) }}" 
                        style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 5px;">
                    @error('adresse') <span class="error-msg" style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>

                <div class="info-row" style="background: transparent; border: none; padding: 0; margin-bottom: 20px;">
                    <label for="zone_id" style="display: block; font-weight: bold; margin-bottom: 5px;">Ville/Zone :</label>
                    <select id="zone_id" name="zone_id" 
                        style="width: 100%; padding: 10px; border: 1px solid var(--color-border); border-radius: 5px;">
                        @foreach(App\Models\Zone::all() as $zone)
                            <option value="{{ $zone->id }}" {{ old('zone_id', $hopital->zone_id) == $zone->id ? 'selected' : '' }}>
                                {{ $zone->nom }} ({{ $zone->ville }})
                            </option>
                        @endforeach
                    </select>
                    @error('zone_id') <span class="error-msg" style="color: red; font-size: 0.8em;">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn primary-btn" style="background-color: var(--color-hopital); margin-top: 10px;">
                    <i class="fas fa-save"></i> Enregistrer les modifications
                </button>
            </form>
        </div>

        <div class="settings-card">
            <h3><i class="fas fa-check-circle"></i> Statut & Validation</h3>

            <div class="info-row">
                <strong>Statut de l'établissement :</strong><br>
                @if($hopital->statut == 'verifie')
                    <span class="status-badge status-verified">Vérifié et Actif</span>
                @elseif($hopital->statut == 'en_attente')
                    <span class="status-badge status-pending">En attente de validation</span>
                @else
                    <span class="status-badge" style="background:#ffebee; color:#c62828;">Rejeté</span>
                @endif
            </div>

            <div class="info-row">
                <strong>Dernière mise à jour :</strong><br>
                {{ $hopital->updated_at->format('d/m/Y H:i') }}
            </div>

            <h3 style="margin-top: 30px;"><i class="fas fa-chart-line"></i> Statistiques</h3>

            <div class="info-row">
                <strong>Médecins affiliés :</strong> {{ $hopital->medecins()->count() }}
            </div>

            <div class="info-row">
                <strong>Patients traités :</strong> {{ $hopital->patients()->count() }}
            </div>

            <div class="info-row" style="margin-top: 20px; border-left-color: var(--color-primary-blue);">
                <a href="{{ route('hopital.specialites.index') }}" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-hand-holding-medical" style="color: var(--color-primary-blue);"></i>
                    <strong>Gérer nos Spécialités & Services</strong>
                </a>
            </div>
        </div>
    </section>
@endsection