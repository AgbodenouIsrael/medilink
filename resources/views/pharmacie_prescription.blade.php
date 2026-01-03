<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Digital Prescriptions - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }

        /* Liste des ordonnances (Gauche) */
        .prescriptions-list-card {
            background: white;
            border: 1px solid var(--border-color);
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
        .prescription-item:hover { background: #F8F9FA; }
        .prescription-item.active {
            background: #f0fdf4;
            border-right: 4px solid var(--primary-green);
        }

        /* Détails (Droite) */
        .details-placeholder {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #888;
        }
        .details-placeholder i { font-size: 4em; margin-bottom: 20px; opacity: 0.2; }

        /* Badges de statut (exactement comme sur l'image) */
        .badge {
            float: right;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        .badge-pending { background: #FFF4E5; color: #B76E00; }
        .badge-validated { background: #E8F5E9; color: #2E7D32; }
        .badge-completed { background: #F3E5F5; color: #7B1FA2; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div style="padding: 25px;"><h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1></div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_pharmacie') }}" class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="{{ route('pharmacie_prescriptions') }}" class="nav-item"><i class="fas fa-file-medical"></i>Prescription Digitale </a>
            <a href="{{ route('pharmacie_inventory') }}" class="nav-item"><i class="fas fa-boxes"></i> Inventaire</a>
            <a href="{{ route('pharmacie_sales') }}" class="nav-item"><i class="fas fa-cash-register"></i> Ventes / Point de vente</a>
            <a href="{{ route('pharmacie_profil') }}" class="nav-item"><i class="fas fa-user-cog"></i> Paramètres du profil</a>
        </nav>
    </aside>

    <div id="validationModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white; width:500px; border-radius:12px; padding:30px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
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
            <button onclick="closeModal()" style="flex:1; padding:12px; border-radius:8px; border:1px solid #ddd; background:white; cursor:pointer;">Annuler</button>
            <button onclick="confirmValidation()" style="flex:1; padding:12px; border-radius:8px; border:none; background:var(--primary-green); color:white; font-weight:600; cursor:pointer;">Confirmer la délivrance</button>
        </div>
    </div>
</div>

    <main class="main-content">
        <header style="display:flex; justify-content:space-between; align-items:center; margin-bottom:25px;">
            <div>
                <h1 style="margin:0;">Prescription Digitale </h1>
                <p style="color:#666;">Gérer et valider les ordonnances des médecins</p>
            </div>
            <div style="display:flex; gap:10px;">
                <button class="filter-chip"><i class="fas fa-file-export"></i> Export</button>
                <button class="filter-chip" style="background:var(--primary-green); color:white;"><i class="fas fa-plus"></i> Nouvelles Prescriptions</button>
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
                    
                    <div class="prescription-item">
                        <span class="badge badge-pending">En attente</span>
                        <strong style="font-size: 16px;">Amina Kouassi</strong><br>
                        <span style="font-size: 13px; color:#666;">Dr. Kofi Mensah</span>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:12px; color:#aaa;">
                            <div><span>RX-2024-001</span> · <small>2024-01-15</small></div>
                            <button class="validate-btn" style="background:var(--primary-green);color:white;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">Valider</button>
                        </div>
                    </div>

                    <div class="prescription-item active">
                        <span class="badge badge-validated">Validé</span>
                        <strong style="font-size: 16px;">Kwame Addo</strong><br>
                        <span style="font-size: 13px; color:#666;">Dr. Ama Diop</span>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:12px; color:#aaa;">
                            <div><span>RX-2024-002</span> · <small>2024-01-15</small></div>
                            <button class="validate-btn" style="background:#f0f0f0;color:#333;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">Voir</button>
                        </div>
                    </div>

                    <div class="prescription-item">
                        <span class="badge badge-completed">Terminé</span>
                        <strong style="font-size: 16px;">Fatou Traoré</strong><br>
                        <span style="font-size: 13px; color:#666;">Dr. Jean Baptiste</span>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:12px; color:#aaa;">
                            <div><span>RX-2024-003</span> · <small>2024-01-14</small></div>
                            <button class="validate-btn" style="background:#f0f0f0;color:#333;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">Voir</button>
                        </div>
                    </div>

                    <div class="prescription-item">
                        <span class="badge badge-pending">En attente</span>
                        <strong style="font-size: 16px;">Yao Koffi</strong><br>
                        <span style="font-size: 13px; color:#666;">Dr. Kofi Mensah</span>
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-top:10px; font-size:12px; color:#aaa;">
                            <div><span>RX-2024-004</span> · <small>2024-01-14</small></div>
                            <button class="validate-btn" style="background:var(--primary-green);color:white;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;">Valider</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="details-view details-placeholder">
                <i class="far fa-file-alt"></i>
                <h3 style="color:#333;">Sélectionnez une prescription pour voir les détails</h3>
                <p>Choisissez un élément de la liste pour voir tous les détails médicaux,<br>l'historique du patient et les options de validation.</p>
            </div>
        </div>
    </main>

<script>

    // Fonction pour ouvrir la modale
    function openValidation(patientName, doctorName, row) {
        document.getElementById('modalPatient').innerText = patientName;
        document.getElementById('modalDoctor').innerText = doctorName;
        document.getElementById('validationModal').style.display = 'flex';
        // remember selected row for confirmation
        window._lastPrescriptionRow = row || null;
    }

// Fonction pour fermer la modale
function closeModal() {
    document.getElementById('validationModal').style.display = 'none';
}

// Fonction de confirmation finale
function confirmValidation() {
    // mark the selected prescription as completed
    if (window._lastPrescriptionRow) {
        const badge = window._lastPrescriptionRow.querySelector('.badge');
        if (badge) { badge.className = 'badge badge-completed'; badge.innerText = 'Terminé'; }
    }
    alert("Ordonnance validée ! Les médicaments ont été déduits du stock et la vente est enregistrée.");
    closeModal();
}

// Attacher l'événement aux boutons "Validate" existants
// Attach validate action for validate buttons
document.querySelectorAll('.validate-btn, .btn-reorder').forEach(btn => {
    btn.addEventListener('click', function(e) {
        const row = this.closest('.prescription-item');
        const patient = (row.querySelector('strong') && row.querySelector('strong').innerText) || '';
        const doctor = (row.querySelector('span') && row.querySelector('span').innerText) || '';
        openValidation(patient, doctor, row);
    });
});

// include shared behavior script
var s = document.createElement('script'); s.src = 'medilink_pharmacy.js'; document.body.appendChild(s);

</script>

</body>
</html>{}