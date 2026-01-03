<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Medilink Pharmacie</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     <style>
        .dashboard-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 25px; }
        .card { background: white; border-radius: 12px; border: 1px solid #eee; padding: 20px; margin-bottom: 25px; }
        .prescription-item { border-bottom: 1px solid #f5f5f5; padding: 15px 0; }
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-pending { background: #FFF4E5; color: #B76E00; }
        .badge-validated { background: #E3F2FD; color: #1976D2; }
        .stock-alert-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
        .btn-reorder { background: #00A651; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; }
        .quick-action { display: flex; align-items: center; padding: 15px; border: 1px solid #eee; border-radius: 10px; margin-bottom: 10px; cursor: pointer; transition: 0.2s; }
        .quick-action:hover { background: #f8f9fa; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div> <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1></div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_pharmacie') }}" class="nav-item active"><i class="fas fa-th-large"></i> Dashboard</a>
            <a href="{{ route('pharmacie_prescriptions') }}" class="nav-item"><i class="fas fa-file-medical"></i>Prescription Digitale </a>
            <a href="{{ route('pharmacie_inventory') }}" class="nav-item"><i class="fas fa-boxes"></i> Inventaire</a>
            <a href="{{ route('pharmacie_sales') }}" class="nav-item"><i class="fas fa-cash-register"></i> Ventes / Point de vente</a>
            <a href="{{ route('pharmacie_profil') }}" class="nav-item"><i class="fas fa-user-cog"></i> Paramètres du profil</a>
        </nav>
        <div class="user-profile" style="padding: 20px; border-top: 1px solid #eee;">
            <div style="display:flex; align-items:center;">
                <div style="width:40px; height:40px; background:#00A651; color:white; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-right:10px;">PH</div>
                <div><strong>Pharmacie</strong><br><small>Lomé, Togo</small></div>
            </div>
        </div>
    </aside>

    <main class="main-content">
        <header style="display:flex; justify-content:space-between; margin-bottom:30px;">
            <div>
                <h1 style="margin:0;">Tableau de bord</h1>
                <p style="color:#666;">Bienvenue ! Voici le programme du jour.</p>
            </div>
            <div class="search-bar" style="position:relative;">
                <input type="text" placeholder="Search medicines..." style="width:400px; padding:10px 40px; border-radius:8px; border:1px solid #ddd;">
                <i class="fas fa-search" style="position:absolute; left:15px; top:13px; color:#aaa;"></i>
            </div>
        </header>

        <div class="dashboard-grid">
            <div class="left-col">
                <div class="card">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                        <h3>Prescription Digitale</h3>
                        <a href="#" style="color:#00A651; text-decoration:none; font-weight:600;">Voir tout</a>
                    </div>
                    
                    <div class="prescription-item">
                        <div style="display:flex; justify-content:space-between;">
                            <div><strong>Amina Diallo</strong> <span class="badge badge-pending">En attente</span></div>
                            <small style="color:#999;">RX-2024-001</small>
                        </div>
                        <p style="margin:5px 0; font-size:14px; color:#666;">Prescrit par Dr. Kofi Mensah</p>
                        <div style="display:flex; gap:10px; margin:10px 0;">
                            <span style="background:#f0f0f0; padding:4px 10px; border-radius:4px; font-size:12px;">Amoxicillin 500mg</span>
                            <span style="background:#f0f0f0; padding:4px 10px; border-radius:4px; font-size:12px;">Paracetamol 1g</span>
                        </div>
                        <button class="btn-reorder" style="background:#00A651;">Valider</button>
                        <button style="border:none; background:none; color:#666; cursor:pointer; margin-left:10px;">Voir les détails</button>
                    </div>
                    <div class="prescription-item">
                        <div style="display:flex; justify-content:space-between;">
                            <div><strong>Kwame Asante</strong> <span class="badge badge-validated">Validé</span></div>
                            <small style="color:#999;">RX-2024-002</small>
                        </div>
                        <button style="border:none; background:none; color:#666; cursor:pointer; margin-top:10px;">Voir les détails</button>
                    </div>
                </div>

                <div class="card">
                    <div style="display:flex; justify-content:space-between;">
                        <h3>Analytics des ventes quotidiennes</h3>
                        <h2 style="margin:0;">58 900 CFA <span style="font-size:14px; color:#00A651;">+12.6%</span></h2>
                    </div>
                    <canvas id="salesChart" height="100"></canvas>
                </div>
            </div>

            <div class="right-col">
                <div class="card">
                    <h3>Alertes de stocks</h3>
                    <p style="color:#999; font-size:14px;">Stock faible (3)</p>
                    <div class="stock-alert-item">
                        <div><strong>Paracetamol 500mg</strong><br><small>Actuel: 45 | Min: 100</small></div>
                        <button class="btn-reorder">Réorganiser</button>
                    </div>
                    <div class="stock-alert-item">
                        <div><strong>Ibuprofen 400mg</strong><br><small>Actuel: 28 | Min: 80</small></div>
                        <button class="btn-reorder">Réorganiser</button>
                    </div>
                    <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">
                    <p style="color:#999; font-size:14px;">Expiration prochaine (3)</p>
                    <div class="stock-alert-item">
                        <div><strong>Amoxicillin 250mg</strong><br><small style="color:red;">Expiré: 2024-02-15</small></div>
                        <button style="border:1px solid #ddd; padding:5px 10px; border-radius:6px; background:none;">Revoir</button>
                    </div>
                </div>

                <div class="card">
                    <h3>Actions rapides</h3>
                    <div class="quick-action">
                        <i class="fas fa-shopping-cart" style="color:#00A651; margin-right:15px;"></i>
                        <div><strong>Nouvelle vente</strong><br><small>Traiter une nouvelle transaction</small></div>
                    </div>
                    <div class="quick-action">
                        <i class="fas fa-plus-circle" style="color:#00A651; margin-right:15px;"></i>
                        <div><strong> <a href="pharmacie_add_product.html"> Ajouter un produit</strong><br><small>Ajouter un nouvel article à l'inventaire</small></a></div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Simulation du graphique
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['08:00', '10:00', '12:00', '14:00', '16:00'],
                datasets: [{
                    label: 'Sales (CFA)',
                    data: [12000, 24000, 21000, 38000, 45000],
                    borderColor: '#00A651',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(0, 166, 81, 0.1)'
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    </script>
    <script src="medilink_pharmacy.js"></script>
</body>
</html>