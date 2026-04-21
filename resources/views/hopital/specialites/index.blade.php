@extends('layouts.hopital')

@section('title', 'Gestion des Spécialités - MediLink')

@section('styles')
    <style>
        .specialty-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            color: var(--color-hopital);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .specialty-list {
            list-style: none;
            padding: 0;
        }

        .specialty-item {
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .specialty-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .specialty-name {
            font-weight: bold;
            color: #333;
        }

        .specialty-desc {
            font-size: 0.9em;
            color: #666;
            background: #f9f9f9;
            padding: 8px;
            border-radius: 4px;
        }

        .btn-remove {
            color: #dc3545;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
        }

        .btn-remove:hover {
            color: #bd2130;
        }

        .update-form {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .update-form input {
            flex: 1;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.85em;
        }

        .add-form .input-group {
            margin-bottom: 15px;
        }

        .add-form select,
        .add-form textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Spécialités & Services de l'Établissement</h2>
        <p>Définissez les services que vous offrez pour permettre aux patients de vous trouver plus facilement.</p>
    </header>

    <div class="specialty-container">
        <!-- New Specialty Form -->
        <div class="card">
            <h3><i class="fas fa-plus-circle"></i> Ajouter un service</h3>
            <form action="{{ route('hopital.specialites.add') }}" method="POST" class="add-form">
                @csrf
                <div class="input-group">
                    <label for="specialite_id">Sélectionner une spécialité</label>
                    <select name="specialite_id" id="specialite_id" required>
                        <option value="">-- Choisir une spécialité --</option>
                        @foreach($allSpecialites as $spec)
                            <option value="{{ $spec->id }}">{{ $spec->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group">
                    <label for="description">Description courte (optionnel)</label>
                    <textarea name="description" id="description" rows="3"
                        placeholder="Ex: Service d'urgence 24/7, Maternité équipée..."></textarea>
                </div>
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-hopital);">
                    Ajouter ce service
                </button>
            </form>
        </div>

        <!-- Current Specialties List -->
        <div class="card">
            <h3><i class="fas fa-list-ul"></i> Nos Services Actuels</h3>
            <ul class="specialty-list">
                @forelse($currentSpecialites as $spec)
                    <li class="specialty-item">
                        <div class="specialty-header">
                            <span class="specialty-name">{{ $spec->nom }}</span>
                            <form action="{{ route('hopital.specialites.remove', $spec->id) }}" method="POST"
                                onsubmit="return confirm('Voulez-vous vraiment retirer ce service ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-remove" title="Retirer">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>

                        <div class="specialty-desc">
                            {{ $spec->pivot->description ?: 'Aucune description fournie.' }}
                        </div>

                        <form action="{{ route('hopital.specialites.update', $spec->id) }}" method="POST" class="update-form">
                            @csrf
                            @method('PUT')
                            <input type="text" name="description" value="{{ $spec->pivot->description }}"
                                placeholder="Mettre à jour la description...">
                            <button type="submit" class="btn primary-btn small-btn"
                                style="background-color: var(--color-hopital);">Ok</button>
                        </form>
                    </li>
                @empty
                    <p style="text-align: center; color: #666; padding: 20px;">
                        Aucune spécialité enregistrée pour le moment.
                    </p>
                @endforelse
            </ul>
        </div>
    </div>
@endsection