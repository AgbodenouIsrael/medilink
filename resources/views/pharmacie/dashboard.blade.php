@extends('layouts.pharmacie')

@section('title', 'Dashboard - Medilink Pharmacie')

@section('styles')
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 20px;
            margin-bottom: 25px;
        }

        .prescription-item {
            border-bottom: 1px solid #f5f5f5;
            padding: 15px 0;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-pending {
            background: #FFF4E5;
            color: #B76E00;
        }

        .badge-validated {
            background: #E3F2FD;
            color: #1976D2;
        }

        .stock-alert-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .btn-reorder {
            background: #00A651;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .quick-action {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .quick-action:hover {
            background: #f8f9fa;
        }
    </style>
@endsection

@section('content')
    <header style="display:flex; justify-content:space-between; margin-bottom:30px;">
        <div>
            <h1 style="margin:0;">Tableau de bord</h1>
            <p style="color:#666;">Bienvenue, {{ Auth::guard('pharmacie')->user()->pharmacien_titulaire }} ! Voici
                le programme du jour.</p>
        </div>
        <div class="search-bar" style="position:relative;">
            <input type="text" placeholder="Search medicines..."
                style="width:400px; padding:10px 40px; border-radius:8px; border:1px solid #ddd;">
            <i class="fas fa-search" style="position:absolute; left:15px; top:13px; color:#aaa;"></i>
        </div>
    </header>

    <div class="dashboard-grid">
        <div class="left-col">
            <div class="card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
                    <h3>Prescription Digitale</h3>
                    <a href="{{ route('pharmacie_prescriptions') }}"
                        style="color:#00A651; text-decoration:none; font-weight:600;">Voir tout</a>
                </div>

                @forelse($prescriptions as $p)
                    <div class="prescription-item">
                        <div style="display:flex; justify-content:space-between;">
                            <div><strong>{{ $p->patient->prenom }} {{ $p->patient->nom }}</strong> <span
                                    class="badge {{ $p->statut === 'valide' ? 'badge-validated' : 'badge-pending' }}">{{ ucfirst($p->statut) }}</span>
                            </div>
                            <small style="color:#999;">{{ $p->numero_ordonnance }}</small>
                        </div>
                        <p style="margin:5px 0; font-size:14px; color:#666;">Prescrit par Dr. {{ $p->medecin->nom }}</p>
                        <div style="display:flex; gap:10px; margin:10px 0;">
                            {{-- Assuming medications are joined or stored as string for now, if model exists we would loop --}}
                            <span style="background:#f0f0f0; padding:4px 10px; border-radius:4px; font-size:12px;">Ordonnance
                                Digitale</span>
                        </div>
                        <a href="{{ route('pharmacie_prescriptions') }}" class="btn-reorder"
                            style="background:#00A651; text-decoration:none;">Gérer</a>
                    </div>
                @empty
                    <div style="padding: 20px; text-align: center; color: #999;">
                        <i class="fas fa-clipboard-list" style="font-size: 2em; margin-bottom: 10px; opacity: 0.5;"></i>
                        <p>Aucune nouvelle prescription pour le moment.</p>
                    </div>
                @endforelse
            </div>

            <div class="card">
                <div style="display:flex; justify-content:space-between;">
                    <h3>Analytics des ventes quotidiennes</h3>
                    <h2 style="margin:0;">{{ number_format($dailySales, 0, ',', ' ') }} CFA <span
                            style="font-size:14px; color:#00A651;">+0.0%</span></h2>
                </div>
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>

        <div class="right-col">
            <div class="card">
                <h3>Alertes de stocks</h3>
                <p style="color:#999; font-size:14px;">Stock faible ({{ $stockAlerts->count() }})</p>

                @forelse($stockAlerts->take(3) as $alert)
                    <div class="stock-alert-item">
                        <div><strong>{{ $alert->nom }} {{ $alert->dosage }}</strong><br><small>Actuel:
                                {{ $alert->quantite }} | Min: {{ $alert->seuil_alerte }}</small></div>
                        <a href="{{ route('pharmacie.inventory') }}" class="btn-reorder"
                            style="text-decoration:none; display:inline-block; text-align:center;">Gérer</a>
                    </div>
                @empty
                    <p style="font-size:13px; color:#aaa; font-style:italic; margin-bottom:15px;">Aucune alerte de
                        stock.</p>
                @endforelse

                <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">
                <p style="color:#999; font-size:14px;">Expiration prochaine ({{ $expiringProducts->count() }})</p>

                @forelse($expiringProducts->take(3) as $product)
                    <div class="stock-alert-item">
                        <div><strong>{{ $product->nom }}</strong><br><small style="color:red;">Expire:
                                {{ \Carbon\Carbon::parse($product->date_expiration)->format('d/m/Y') }}</small></div>
                        <a href="{{ route('pharmacie.inventory') }}"
                            style="border:1px solid #ddd; padding:5px 10px; border-radius:6px; background:none; text-decoration:none; color:black; font-size:13px;">Revoir</a>
                    </div>
                @empty
                    <p style="font-size:13px; color:#aaa; font-style:italic;">Aucun produit n'expire bientôt.</p>
                @endforelse
            </div>

            <div class="card">
                <h3>Actions rapides</h3>
                <div class="quick-action" onclick="window.location.href='{{ route('pharmacie_sales') }}'">
                    <i class="fas fa-shopping-cart" style="color:#00A651; margin-right:15px;"></i>
                    <div><strong>Nouvelle vente</strong><br><small>Traiter une nouvelle transaction</small></div>
                </div>
                <div class="quick-action">
                    <i class="fas fa-plus-circle" style="color:#00A651; margin-right:15px;"></i>
                    <div><strong> <a href="{{ route('pharmacie.add_product') }}"> Ajouter un
                                produit</strong><br><small>Ajouter un nouvel article à l'inventaire</small></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Simulation du graphique
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['08:00', '10:00', '12:00', '14:00', '16:00'],
                datasets: [{
                    label: 'Sales (CFA)',
                    data: [0, 0, 0, 0, 0], // Placeholder for real hourly data
                    borderColor: '#00A651',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(0, 166, 81, 0.1)'
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    </script>
@endsection