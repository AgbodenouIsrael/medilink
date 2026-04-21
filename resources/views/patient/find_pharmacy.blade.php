@extends('layouts.patient')

@section('title', 'Trouver une Pharmacie - Medilink')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        /* Styles spécifiques pour la recherche de Pharmacie */
        .page-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .map-container {
            flex: 1;
            min-height: 600px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        #pharmacy-map {
            width: 100%;
            height: 600px;
        }

        .results-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .search-container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-left: 5px solid #3498db;
        }

        .search-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .search-form .input-group {
            margin-bottom: 0;
        }

        .search-form .input-group input,
        .search-form .input-group select {
            width: 100%;
            padding: 12px 15px;
            font-size: 1em;
        }

        .search-form button {
            padding: 12px 25px;
            background-color: #3498db;
            color: white;
            width: 100%;
        }

        /* Liste des Résultats */
        .pharmacy-results {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .pharmacy-card {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s;
            cursor: pointer;
        }

        .pharmacy-card:hover {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            border-color: #3498db;
        }

        .pharmacy-card.active {
            border-color: #3498db;
            background-color: #f0f8ff;
        }

        .pharmacy-info h4 {
            color: #3498db;
            margin-bottom: 5px;
            font-size: 1.1em;
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

        .distance-badge {
            background-color: #e3f2fd;
            color: #1976D2;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85em;
            font-weight: bold;
            display: inline-block;
            margin-left: 10px;
        }

        .open {
            background-color: #e8f5e9;
            color: #4CAF50;
        }

        .closed {
            background-color: #ffebee;
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

        @media (max-width: 1024px) {
            .page-container {
                flex-direction: column;
            }

            .map-container {
                min-height: 400px;
            }

            #pharmacy-map {
                height: 400px;
            }
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Trouver une Pharmacie</h2>
        <p>Recherchez les pharmacies et vérifiez la disponibilité des médicaments.</p>
    </header>

    <div class="page-container">
        <!-- Map Section -->
        <div class="map-container">
            <div id="pharmacy-map"></div>
        </div>

        <!-- Results Section -->
        <div class="results-container">
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
            <div class="input-group">
                <label for="zone_search"><i class="fas fa-map-marker-alt"></i> Recherche par Zone</label>
                <input type="text" id="zone_search" name="zone" placeholder="Ex: Paris 15e, Lomé centre"
                    value="{{ old('zone', $searchQuery['zone'] ?? '') }}">
                @error('zone') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="input-group">
                <label for="medicament_search"><i class="fas fa-pills"></i> Recherche de Médicament (Optionnel)</label>
                <input type="text" id="medicament_search" name="medicament" placeholder="Ex: Paracétamol, Amoxicilline"
                    value="{{ old('medicament', $searchQuery['medicament'] ?? '') }}">
                @error('medicament') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn primary-btn"><i class="fas fa-search"></i> Rechercher</button>
        </form>

            </div>

            <div>
                @if($searchQuery['zone'] || $searchQuery['medicament'])
                    <h3>Résultats de recherche ({{ $pharmacies->count() }})</h3>
                @else
                    <h3>Toutes les Pharmacies ({{ $pharmacies->count() }})</h3>
                @endif
            </div>

            <section class="pharmacy-results">

        @forelse($pharmacies as $pharmacie)
            <div class="pharmacy-card" data-pharmacy-id="{{ $pharmacie->id }}" 
                 data-lat="{{ $pharmacie->latitude }}" data-lng="{{ $pharmacie->longitude }}"
                 onclick="focusPharmacy({{ $pharmacie->id }}, {{ $pharmacie->latitude }}, {{ $pharmacie->longitude }})">
                <div class="pharmacy-info">
                    <h4>{{ $pharmacie->nom_officine }}
                        <span class="status-badge {{ $pharmacie->en_ligne ? 'open' : 'closed' }}">
                            {{ $pharmacie->en_ligne ? 'Ouverte' : 'Fermée' }}
                        </span>
                        @if($pharmacie->distance)
                            <span class="distance-badge">
                                <i class="fas fa-map-marker-alt"></i> {{ $pharmacie->distance }} km
                            </span>
                        @endif
                    </h4>
                    <p><i class="fas fa-map-pin"></i> {{ $pharmacie->adresse_complete }}, {{ $pharmacie->zone->nom ?? 'N/A' }}
                    </p>
                    <p><i class="fas fa-phone"></i> {{ $pharmacie->telephone }}</p>
                    @if($searchQuery['medicament'] ?? null)
                        <p>
                            <i class="fas fa-flask"></i>
                            Stock: Vérification disponible sur demande
                        </p>
                    @endif
                </div>
                <div class="pharmacy-actions">
                    <a href="#" class="btn primary-btn" onclick="event.stopPropagation(); getDirections({{ $pharmacie->latitude }}, {{ $pharmacie->longitude }})">
                        <i class="fas fa-route"></i> Voir Itinéraire
                    </a>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 40px; color: #666;">
                <i class="fas fa-search" style="font-size: 3em; margin-bottom: 15px; color: #ddd;"></i>
                <p>Aucune pharmacie trouvée.</p>
                @if($searchQuery['medicament'] ?? null)
                    <p><small>Essayez de rechercher sans médicament spécifique.</small></p>
                @endif
            </div>
        @endforelse

            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        let map;
        let markers = {};
        let activeMarkerId = null;

        // Initialize map
        document.addEventListener('DOMContentLoaded', function () {
            // Default center (Lomé, Togo or user's location)
            const defaultLat = {{ $patientLat ?? 6.1319 }};
            const defaultLng = {{ $patientLng ?? 1.2225 }};

            // Initialize the map
            map = L.map('pharmacy-map').setView([defaultLat, defaultLng], 13);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Add patient location marker if available
            @if($patientLat && $patientLng)
                const patientIcon = L.icon({
                    iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                    shadowSize: [41, 41]
                });

                L.marker([{{ $patientLat }}, {{ $patientLng }}], { icon: patientIcon })
                    .addTo(map)
                    .bindPopup('<b>Votre position approximative</b>')
                    .openPopup();
            @endif

            // Add pharmacy markers
            const pharmacies = @json($pharmacies);
            const bounds = [];

            pharmacies.forEach(function (pharmacy) {
                if (pharmacy.latitude && pharmacy.longitude) {
                    const lat = parseFloat(pharmacy.latitude);
                    const lng = parseFloat(pharmacy.longitude);

                    // Create marker
                    const marker = L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup(`
                            <div style="min-width: 200px;">
                                <h4 style="margin: 0 0 10px 0; color: #3498db;">${pharmacy.nom_officine}</h4>
                                <p style="margin: 5px 0;"><i class="fas fa-map-pin"></i> ${pharmacy.adresse_complete}</p>
                                <p style="margin: 5px 0;"><i class="fas fa-phone"></i> ${pharmacy.telephone}</p>
                                ${pharmacy.distance ? `<p style="margin: 5px 0;"><i class="fas fa-map-marker-alt"></i> ${pharmacy.distance} km</p>` : ''}
                                <span class="status-badge ${pharmacy.en_ligne ? 'open' : 'closed'}" style="margin-top: 10px; display: inline-block;">
                                    ${pharmacy.en_ligne ? 'Ouverte' : 'Fermée'}
                                </span>
                            </div>
                        `);

                    markers[pharmacy.id] = marker;
                    bounds.push([lat, lng]);

                    // Click handler
                    marker.on('click', function () {
                        highlightPharmacyCard(pharmacy.id);
                    });
                }
            });

            // Fit map to show all markers
            if (bounds.length > 0) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        });

        // Focus on a specific pharmacy
        function focusPharmacy(id, lat, lng) {
            if (lat && lng) {
                map.setView([lat, lng], 15);
                if (markers[id]) {
                    markers[id].openPopup();
                }
            }
            highlightPharmacyCard(id);
        }

        // Highlight pharmacy card
        function highlightPharmacyCard(id) {
            // Remove previous highlight
            document.querySelectorAll('.pharmacy-card').forEach(card => {
                card.classList.remove('active');
            });

            // Add highlight to selected card
            const card = document.querySelector(`[data-pharmacy-id="${id}"]`);
            if (card) {
                card.classList.add('active');
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            activeMarkerId = id;
        }

        // Get directions (opens Google Maps)
        function getDirections(lat, lng) {
            if (lat && lng) {
                window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, '_blank');
            }
        }

        // Form validation
        const form = document.querySelector('.search-form');
        if (form) {
            const submitBtn = form.querySelector('button[type="submit"]');
            form.addEventListener('submit', function (e) {
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Recherche...';
                }
            });
        }
    </script>
@endsection