@extends('layouts.patient')

@section('title', 'Guide des Hôpitaux - Medilink')

@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <style>
        /* Styles spécifiques pour le Guide des Hôpitaux */
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

        #hospital-map {
            width: 100%;
            height: 600px;
        }

        .results-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .search-controls {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.03);
            border-left: 5px solid #3498db;
        }

        .search-controls .input-group {
            margin-bottom: 0;
        }

        .search-controls .input-group select {
            width: 100%;
            padding: 12px 15px;
            font-size: 1em;
        }

        .search-controls button {
            width: 100%;
            margin-top: 10px;
            padding: 12px 25px;
        }

        .hospital-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            max-height: 500px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .hospital-card {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e9e9e9;
            transition: all 0.3s;
            cursor: pointer;
        }

        .hospital-card:hover {
            border-color: #3498db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .hospital-card.active {
            border-color: #3498db;
            background-color: #f0f8ff;
        }

        .hospital-card h4 {
            color: #3498db;
            margin-bottom: 5px;
            font-size: 1.1em;
        }

        .hospital-card p {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 5px;
        }

        .hospital-card .actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .actions .btn {
            padding: 7px 12px;
            font-size: 0.85em;
        }

        .btn-itineraire {
            background-color: #6c757d;
        }

        .btn-itineraire:hover {
            background-color: #5a6268;
        }

        @media (max-width: 1024px) {
            .page-container {
                flex-direction: column;
            }

            .map-container {
                min-height: 400px;
            }

            #hospital-map {
                height: 400px;
            }
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Guide des Hôpitaux & Centres de Santé</h2>
        <p>Trouvez un établissement de santé, demandez un rendez-vous ou obtenez un itinéraire.</p>
    </header>

    <div class="page-container">
        <!-- Map Section -->
        <div class="map-container">
            <div id="hospital-map"></div>
        </div>

        <!-- Results Section -->
        <div class="results-container">
            <div class="search-controls">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="input-group">
                        <label for="specialite_recherche"><i class="fas fa-search"></i> Recherche par Spécialité /
                            Soins</label>
                        <select id="specialite_recherche" name="specialite">
                            <option value="">Toutes les spécialités...</option>
                            @foreach($specialties as $specialty)
                                <option value="{{ $specialty }}" {{ ($selectedSpecialty == $specialty) ? 'selected' : '' }}>
                                    {{ $specialty }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn primary-btn">
                        <i class="fas fa-filter"></i> Filtrer
                    </button>
                </form>
            </div>

            <div>
                @if($selectedSpecialty)
                    <h3>Résultats de recherche ({{ $hospitals->count() }})</h3>
                @else
                    <h3>Tous les Hôpitaux ({{ $hospitals->count() }})</h3>
                @endif
            </div>

            <div class="hospital-list">
                @forelse($hospitals as $hopital)
                    <div class="hospital-card" data-hospital-id="{{ $hopital->id }}"
                        onclick="focusHospital({{ $hopital->id }}, '{{ $hopital->nom }}', '{{ $hopital->adresse }}')">
                        <h4>{{ $hopital->nom }}
                            <span
                                style="font-size: 0.8em; color: #555;">({{ $hopital->zone->ville ?? $hopital->zone->nom ?? 'N/A' }})</span>
                        </h4>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $hopital->adresse }}</p>
                        <p><i class="fas fa-phone"></i> {{ $hopital->contact }}</p>
                        @if($hopital->medecins->count() > 0)
                            <p><i class="fas fa-user-md"></i> {{ $hopital->medecins->count() }} médecin(s) affilié(s)</p>
                        @endif
                        @if($hopital->specialites->count() > 0)
                            <div style="display: flex; flex-wrap: wrap; gap: 5px; margin-top: 5px;">
                                @foreach($hopital->specialites as $spec)
                                    <span
                                        style="background: #e8f4fd; color: #3498db; font-size: 0.75em; padding: 2px 8px; border-radius: 10px; border: 1px solid #d1e9fb;">
                                        {{ $spec->nom }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                        <div class="actions">
                            <a href="#" class="btn primary-btn small-btn" onclick="event.stopPropagation();">Demander RDV</a>
                            <a href="#" class="btn small-btn btn-itineraire"
                                onclick="event.stopPropagation(); getDirections('{{ $hopital->nom }}', '{{ $hopital->adresse }}')">
                                <i class="fas fa-directions"></i> Voir Itinéraire
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <i class="fas fa-hospital" style="font-size: 3em; margin-bottom: 15px; color: #ddd;"></i>
                        <p>Aucun hôpital trouvé.</p>
                        @if($selectedSpecialty)
                            <p><small>Essayez de rechercher sans filtre de spécialité.</small></p>
                        @endif
                    </div>
                @endforelse
            </div>
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
            map = L.map('hospital-map').setView([defaultLat, defaultLng], 12);

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

                    // Add hospital markers (grouped by zone since we don't have exact coordinates)
                    const hospitals = @json($hospitals);
            const zoneMarkers = {};

            hospitals.forEach(function (hospital, index) {
                const zoneName = hospital.zone ? (hospital.zone.ville || hospital.zone.nom) : 'Unknown';

                // Group hospitals by zone
                if (!zoneMarkers[zoneName]) {
                    zoneMarkers[zoneName] = [];
                }
                zoneMarkers[zoneName].push(hospital);
            });

            // Create markers for each zone (approximate locations)
            // In a real scenario, you'd have actual coordinates for each hospital
            const zoneCoordinates = {
                'Lomé': [6.1319, 1.2225],
                'Kara': [9.5511, 1.1864],
                'Sokodé': [8.9833, 1.1333],
                'Atakpamé': [7.5333, 1.1167],
                'Dapaong': [10.8667, 0.2000]
            };

            let markerIndex = 0;
            Object.keys(zoneMarkers).forEach(function (zoneName) {
                const hospitalsInZone = zoneMarkers[zoneName];
                const coords = zoneCoordinates[zoneName] || [defaultLat + (Math.random() - 0.5) * 0.5, defaultLng + (Math.random() - 0.5) * 0.5];

                hospitalsInZone.forEach(function (hospital, idx) {
                    // Offset markers slightly if multiple in same zone
                    const lat = coords[0] + (idx * 0.01);
                    const lng = coords[1] + (idx * 0.01);

                    const marker = L.marker([lat, lng])
                        .addTo(map)
                        .bindPopup(`
                                    <div style="min-width: 200px;">
                                        <h4 style="margin: 0 0 10px 0; color: #3498db;">${hospital.nom}</h4>
                                        <p style="margin: 5px 0;"><i class="fas fa-map-marker-alt"></i> ${hospital.adresse}</p>
                                        <p style="margin: 5px 0;"><i class="fas fa-phone"></i> ${hospital.contact}</p>
                                        ${hospital.medecins_count > 0 ? `<p style="margin: 5px 0;"><i class="fas fa-user-md"></i> ${hospital.medecins_count} médecin(s)</p>` : ''}
                                    </div>
                                `);

                    markers[hospital.id] = { marker: marker, lat: lat, lng: lng };

                    marker.on('click', function () {
                        highlightHospitalCard(hospital.id);
                    });
                });
            });
        });

        // Focus on a specific hospital
        function focusHospital(id, name, address) {
            if (markers[id]) {
                map.setView([markers[id].lat, markers[id].lng], 14);
                markers[id].marker.openPopup();
            }
            highlightHospitalCard(id);
        }

        // Highlight hospital card
        function highlightHospitalCard(id) {
            document.querySelectorAll('.hospital-card').forEach(card => {
                card.classList.remove('active');
            });

            const card = document.querySelector(`[data-hospital-id="${id}"]`);
            if (card) {
                card.classList.add('active');
                card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }

            activeMarkerId = id;
        }

        // Get directions (opens Google Maps with address search)
        function getDirections(name, address) {
            const query = encodeURIComponent(name + ', ' + address);
            window.open(`https://www.google.com/maps/search/?api=1&query=${query}`, '_blank');
        }
    </script>
@endsection