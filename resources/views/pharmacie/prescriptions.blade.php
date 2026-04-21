@extends('layouts.pharmacie')

@section('title', 'Digital Prescriptions - Medilink')

@section('styles')
    <style>
        /* Container spécifique à l'affichage divisé de Readdy */
        .prescriptions-container {
            display: grid;
            grid-template-columns: 450px 1fr;
            gap: 20px;
            height: calc(100vh - 160px);
        }

        /* Filtres de statut */
        .status-filters {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-chip {
            padding: 8px 20px;
            border-radius: 8px;
            border: 1px solid #E9ECEF;
            background: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            color: #666;
        }

        .filter-chip.active {
            background: #FF6600;
            color: white;
            border-color: #FF6600;
        }

        /* Liste des ordonnances (Gauche) */
        .prescriptions-list-card {
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .list-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            font-weight: 700;
        }

        .scrollable-list {
            overflow-y: auto;
            flex-grow: 1;
        }

        .prescription-item {
            padding: 20px;
            border-bottom: 1px solid #f5f5f5;
            cursor: pointer;
            transition: 0.2s;
            position: relative;
        }

        .prescription-item:hover {
            background: #F8F9FA;
        }

        .prescription-item.active {
            background: #FFF3E0;
            border-right: 4px solid #FF6600;
        }

        /* Détails (Droite) */
        .details-placeholder {
            background: white;
            border: 1px solid #eee;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #888;
        }

        .details-placeholder i {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.2;
        }

        /* Badges de statut (exactement comme sur l'image) */
        .badge {
            float: right;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-pending {
            background: #FFF4E5;
            color: #B76E00;
        }

        .badge-validated {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .badge-completed {
            background: #F3E5F5;
            color: #7B1FA2;
        }
    </style>
@endsection

@section('content')
    <div id="validationModal"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
        <div
            style="background:white; width:500px; border-radius:12px; padding:30px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
            <h2 style="margin-top:0; border-bottom:1px solid #eee; padding-bottom:15px;">Délivrance Ordonnance</h2>

            <div id="modalContent" style="margin:20px 0;">
                <p><strong>Patient :</strong> <span id="modalPatient">Amina Kouassi</span></p>
                <p><strong>Prescripteur :</strong> <span id="modalDoctor">Dr. Kofi Mensah</span></p>
                <hr style="border:0; border-top:1px solid #eee;">

                <div style="background:#f9f9f9; padding:15px; border-radius:8px; margin-top:15px;">
                    <p style="margin:0 0 10px 0; font-weight:600;">Médicaments à délivrer :</p>
                    <div style="display:flex; justify-content:space-between; margin-bottom:5px;">
                        <span>Amoxicilline 500mg</span> <strong>2 Boîtes</strong>
                    </div>
                    <div style="display:flex; justify-content:space-between;">
                        <span>Paracetamol 1g</span> <strong>1 Boîte</strong>
                    </div>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top:25px;">
                <button onclick="closeModal()"
                    style="flex:1; padding:12px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer;">Annuler</button>
                <button onclick="confirmValidation()"
                    style="flex:1; padding:12px; border-radius:8px; border:none; background:#FF6600; color:white; font-weight:600; cursor:pointer;">Confirmer
                    la délivrance</button>
            </div>
        </div>
    </div>

    <header style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
        <div>
            <h1 style="margin:0;">Prescription Digitale </h1>
            <p style="color:#666;">Gérer et valider les ordonnances des médecins</p>
        </div>
        <div style="display:flex; gap:10px;">
            <button class="filter-chip"><i class="fas fa-file-export"></i> Export</button>
            <button class="filter-chip" style="background:#FF6600; color:white;"><i class="fas fa-plus"></i> Nouvelles
                Prescriptions</button>
        </div>
    </header>

    <div class="status-filters">
        <button class="filter-chip active">Tout</button>
        <button class="filter-chip">En attente</button>
        <button class="filter-chip">Validé</button>
        <button class="filter-chip">Terminé</button>
    </div>

    <div class="prescriptions-container">
        <div class="prescriptions-list-card">
            <div class="list-header">Liste de Prescriptions </div>
            <div class="scrollable-list">

                @forelse($ordonnances as $ordonnance)
                    <div class="prescription-item"
                        onclick="showDetails({{ $ordonnance->id }}, '{{ $ordonnance->patient->prenom }} {{ $ordonnance->patient->nom }}', 'Dr. {{ $ordonnance->medecin->nom }}', '{{ $ordonnance->numero_ordonnance }}', '{{ $ordonnance->date_prescription->format('d/m/Y') }}', {{ json_encode($ordonnance->medicaments) }}, '{{ $ordonnance->statut }}')">
                        <span
                            class="badge {{ $ordonnance->statut === 'terminee' ? 'badge-completed' : ($ordonnance->statut === 'valide' ? 'badge-validated' : 'badge-pending') }}">
                            {{ ucfirst($ordonnance->statut) }}
                        </span>
                        <strong style="font-size: 16px;">{{ $ordonnance->patient->prenom }}
                            {{ $ordonnance->patient->nom }}</strong><br>
                        <span style="font-size: 13px; color:#666;">Dr. {{ $ordonnance->medecin->nom }}</span>
                        <div
                            style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:12px; color:#aaa;">
                            <div><span>{{ $ordonnance->numero_ordonnance }}</span> ·
                                <small>{{ $ordonnance->date_prescription->format('d/m/Y') }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 20px; text-align: center; color: #999;">
                        Aucune prescription trouvée.
                    </div>
                @endforelse

            </div>
        </div>

        <div id="details-view" class="details-view details-placeholder">
            <i class="far fa-file-alt"></i>
            <h3 style="color:#333;">Sélectionnez une prescription pour voir les détails</h3>
            <p>Choisissez un élément de la liste pour voir tous les détails médicaux,<br>l'historique du patient et
                les options de validation.</p>
        </div>

        <!-- Hidden Template for Details -->
        <div id="details-template"
            style="display:none; background:white; border-radius:12px; border:1px solid #eee; padding:30px; width:100%;">
            <div
                style="display:flex; justify-content:space-between; align-items:start; border-bottom:1px solid #eee; padding-bottom:20px; margin-bottom:20px;">
                <div>
                    <h2 id="d-patient" style="margin:0 0 5px 0;">Patient Name</h2>
                    <p id="d-num" style="color:#888; margin:0;">#ORD-XXXX</p>
                </div>
                <div id="d-status" class="badge">Statut</div>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px; margin-bottom:30px;">
                <div>
                    <strong style="display:block; color:#888; font-size:12px; margin-bottom:5px;">MÉDECIN
                        PRESCRIPTEUR</strong>
                    <div id="d-doctor" style="font-weight:600;">Dr. Name</div>
                </div>
                <div>
                    <strong style="display:block; color:#888; font-size:12px; margin-bottom:5px;">DATE</strong>
                    <div id="d-date" style="font-weight:600;">01/01/2026</div>
                </div>
            </div>

            <div style="background:#f9f9f9; padding:20px; border-radius:12px; margin-bottom:30px;">
                <h4 style="margin-top:0;">Médicaments Prescrits</h4>
                <ul id="d-meds" style="padding-left:20px;">
                    <!-- Meds list -->
                </ul>
            </div>

            <button id="btn-serve" onclick="servePrescription()"
                style="width:100%; padding:15px; border-radius:8px; border:none; background:#FF6600; color:white; font-weight:600; cursor:pointer;">
                Marquer comme Servie / Délivrée
            </button>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentId = null;

        function showDetails(id, patient, doctor, numero, date, medicaments, statut) {
            currentId = id;

            // Populate
            document.getElementById('d-patient').innerText = patient;
            document.getElementById('d-doctor').innerText = doctor;
            document.getElementById('d-num').innerText = numero;
            document.getElementById('d-date').innerText = date;

            const badge = document.getElementById('d-status');
            badge.innerText = statut.charAt(0).toUpperCase() + statut.slice(1);
            badge.className = 'badge ' + (statut === 'terminee' ? 'badge-completed' : (statut === 'valide' ? 'badge-validated' : 'badge-pending'));

            const medsList = document.getElementById('d-meds');
            medsList.innerHTML = '';
            if (medicaments && medicaments.length > 0) {
                medicaments.forEach(m => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${m.nom_medicament || m.nom}</strong> ${m.dosage || ''} - ${m.quantite || 1} unité(s)<br><small>${m.instructions || ''}</small>`;
                    li.style.marginBottom = '10px';
                    medsList.appendChild(li);
                });
            } else {
                medsList.innerHTML = '<li style="color:#999">Aucun médicament listé (ou format ancien).</li>';
            }

            // Show/Hide Serve Button
            const btn = document.getElementById('btn-serve');
            if (statut === 'terminee') {
                btn.style.display = 'none';
            } else {
                btn.style.display = 'block';
            }

            // Switch View
            document.querySelector('.details-placeholder').style.display = 'none';
            const container = document.getElementById('details-view');
            container.className = 'details-view'; // remove placeholder class
            container.innerHTML = '';
            container.appendChild(document.getElementById('details-template').cloneNode(true));
            container.querySelector('#details-template').style.display = 'block';
            container.querySelector('#details-template').id = ""; // remove id to avoid dupes

            // Re-attach event to the new button in the DOM
            const newBtn = container.querySelector('#btn-serve');
            if (statut === 'terminee') {
                newBtn.style.display = 'none';
            } else {
                newBtn.onclick = servePrescription;
            }
        }

        function servePrescription() {
            if (!currentId) return;
            if (!confirm("Confirmer la délivrance de cette ordonnance ?")) return;

            fetch(`/pharmacie_prescription/${currentId}/serve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('Ordonnance servie avec succès');
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.message);
                    }
                })
                .catch(err => alert('Erreur de connexion'));
        }
    </script>
@endsection{}