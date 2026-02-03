@extends('layouts.patient')

@section('title', 'Trouver une Pharmacie - Medilink')

@section('styles')
    <style>
        /* Styles spécifiques pour la recherche de Pharmacie */
        .search-container {
            background-color: white;
            /* was var(--color-card-background) which might fail if not defined */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            border-left: 5px solid #3498db;
            /* Thème Bleu Patient */
        }

        .search-form {
            display: flex;
            gap: 20px;
            align-items: flex-end;
        }

        .search-form .input-group {
            flex: 1;
            margin-bottom: 0;
        }

        .search-form button {
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
        }

        /* Liste des Résultats */
        .pharmacy-results {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .pharmacy-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.2s;
        }

        .pharmacy-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .pharmacy-info h4 {
            color: #3498db;
            margin-bottom: 5px;
            font-size: 1.2em;
        }

        .pharmacy-info p {
            color: #555;
            font-size: 0.9em;
            margin: 3px 0;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            font-weight: bold;
            margin-left: 10px;
            display: inline-block;
        }

        .open {
            background-color: #e8f5e9;
            /* Vert très clair */
            color: #4CAF50;
        }

        .closed {
            background-color: #ffebee;
            /* Rouge très clair */
            color: #F44336;
        }

        .pharmacy-actions .btn {
            background-color: #3498db;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            font-size: 0.9em;
        }

        .pharmacy-actions .btn:hover {
            background-color: #1976D2;
        }

        .error-msg {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 4px;
            display: block;
        }

        .input-error {
            border-color: #dc3545 !important;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Trouver une Pharmacie</h2>
        <p>Recherchez les pharmacies de votre zone et vérifiez la disponibilité des médicaments.</p>
    </header>

    <div class="search-container">
        @if(session('success'))
            <div
                style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;display:flex;gap:8px;align-items:center;">
                <i class="fas fa-check-circle"></i>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div
                style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:15px;display:flex;gap:8px;align-items:center;">
                <i class="fas fa-exclamation-triangle"></i>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <form class="search-form" action="{{ url()->current() }}" method="GET" novalidate>
            @csrf
            <div class="input-group">
                <label for="zone_search"><i class="fas fa-map-marker-alt"></i> Ma Zone</label>
                <input type="text" id="zone_search" name="zone" placeholder="Ex: Paris 15e, Lomé centre"
                    value="{{ old('zone', 'Zone du patient') }}" required>
                @error('zone') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="medicament_search"><i class="fas fa-pills"></i> Recherche de Médicament (Optionnel)</label>
                <input type="text" id="medicament_search" name="medicament" placeholder="Ex: Paracétamol, Amoxicilline"
                    value="{{ old('medicament') }}">
                @error('medicament') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn primary-btn"><i class="fas fa-search"></i> Rechercher</button>
        </form>

    </div>

    <h3>Résultats dans la zone [Zone du patient]</h3>

    <section class="pharmacy-results">

        <div class="pharmacy-card">
            <div class="pharmacy-info">
                <h4>Pharmacie Centrale
                    <span class="status-badge open">Ouverte</span>
                </h4>
                <p><i class="fas fa-map-pin"></i> 15 Rue de l'Avenue, [Zone du patient]</p>
                <p><i class="fas fa-phone"></i> +33 1 23 45 67 89</p>
                <p>
                    <i class="fas fa-flask"></i>
                    **Stock:** Paracétamol (Disponible), Amoxicilline (Rupture)
                </p>
            </div>
            <div class="pharmacy-actions">
                <a href="#" class="btn primary-btn"><i class="fas fa-route"></i> Voir Itinéraire</a>
            </div>
        </div>

        <div class="pharmacy-card">
            <div class="pharmacy-info">
                <h4>Pharmacie de la Liberté
                    <span class="status-badge closed">Fermée (Ouvre à 8h)</span>
                </h4>
                <p><i class="fas fa-map-pin"></i> 45 Bd. de l'Espoir, [Zone du patient]</p>
                <p><i class="fas fa-phone"></i> +33 1 98 76 54 32</p>
                <p>
                    <i class="fas fa-flask"></i>
                    **Stock:** Paracétamol (Rupture), Ibuprofène (Disponible)
                </p>
            </div>
            <div class="pharmacy-actions">
                <a href="#" class="btn primary-btn"><i class="fas fa-route"></i> Voir Itinéraire</a>
            </div>
        </div>

        <div class="pharmacy-card">
            <div class="pharmacy-info">
                <h4>Pharmacie de Garde
                    <span class="status-badge open">Ouverte 24/7</span>
                </h4>
                <p><i class="fas fa-map-pin"></i> Près du Grand Hôpital, [Zone du patient]</p>
                <p><i class="fas fa-phone"></i> +33 1 11 22 33 44</p>
                <p><i class="fas fa-flask"></i> Vérification du stock disponible sur demande</p>
            </div>
            <div class="pharmacy-actions">
                <a href="#" class="btn primary-btn"><i class="fas fa-route"></i> Voir Itinéraire</a>
            </div>
        </div>

    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('.search-form'); if (!form) return;
            const submitBtn = form.querySelector('button[type="submit"]');
            form.addEventListener('submit', function (e) {
                form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
                let invalid = false;
                form.querySelectorAll('[required]').forEach(function (el) { if (!el.value || !el.value.toString().trim()) { invalid = true; el.classList.add('input-error'); } });
                if (invalid) { e.preventDefault(); const first = form.querySelector('.input-error'); if (first) first.focus(); return; }
                if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ...'; }
            });
        });
    </script>
@endsection