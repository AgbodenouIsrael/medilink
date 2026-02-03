<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des stocks - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Cartes de résumé (Top Stats) */
        .inventory-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card-mini {
            background: white;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2em;
        }

        /* Tableau Pro */
        .inventory-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 0;
        }

        .table-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            text-align: left;
            padding: 15px 20px;
            background: #F8F9FA;
            color: #666;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .data-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 14px;
        }

        /* Statuts (Badges Image 3) */
        .status-pill {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-instock {
            background: #E8F5E9;
            color: #2E7D32;
        }

        .status-low {
            background: #FFF3E0;
            color: #E65100;
        }

        .status-out {
            background: #FFEBEE;
            color: #C62828;
        }

        .status-expiring {
            background: #FFF8E1;
            color: #F57F17;
            border: 1px solid #FFECB3;
        }

        .action-icon {
            color: #888;
            cursor: pointer;
            margin-left: 10px;
            transition: 0.2s;
        }

        .action-icon:hover {
            color: var(--primary-green);
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div style="padding: 25px;">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </div>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_pharmacie') }}" class="nav-item active"><i class="fas fa-th-large"></i>
                Dashboard</a>
            <a href="{{ route('pharmacie_prescriptions') }}" class="nav-item"><i
                    class="fas fa-file-medical"></i>Prescription Digitale </a>
            <a href="{{ route('pharmacie.inventory') }}" class="nav-item"><i class="fas fa-boxes"></i> Inventaire</a>
            <a href="{{ route('pharmacie_sales') }}" class="nav-item"><i class="fas fa-cash-register"></i> Ventes /
                Point de vente</a>
            <a href="{{ route('pharmacie_profil') }}" class="nav-item"><i class="fas fa-user-cog"></i> Paramètres du
                profil</a>
        </nav>
    </aside>

    <main class="main-content">
        <header style="display:flex; justify-content:space-between; align-items: center; margin-bottom:30px;">
            <div>
                <h1 style="margin:0;">Gestion des stocks</h1>
                <p style="color:#666;">Suivez et gérez votre inventaire de pharmacie.</p>
            </div>
            <div style="display:flex; gap:10px;">
                <button class="btn"
                    style="padding:10px 20px; border:1px solid #ddd; border-radius:8px; background:white;"><i
                        class="fas fa-file-export"></i> Export</button>
                <a href="{{ route('pharmacie.add_product') }}" class="btn"
                    style="padding:10px 20px; border-radius:8px; background:var(--primary-green); color:white; border:none; font-weight:600;"><i
                        class="fas fa-plus"></i> Ajouter un produit</a>
            </div>
        </header>

        <div class="inventory-stats">
            <div class="stat-card-mini">
                <div class="icon-box" style="background:#E8F5E9; color:#00A651;"><i class="fas fa-pills"></i></div>
                <div><small style="color:#888;">Produits Total </small><br><strong>{{ number_format($totalProducts, 0, ',', ' ') }}</strong></div>
            </div>
            <div class="stat-card-mini">
                <div class="icon-box" style="background:#E3F2FD; color:#1976D2;"><i class="fas fa-wallet"></i></div>
                <div><small style="color:#888;">Valeur totale</small><br><strong>{{ number_format($totalValue, 0, ',', ' ') }} CFA</strong></div>
            </div>
            <div class="stat-card-mini">
                <div class="icon-box" style="background:#FFF3E0; color:#EF6C00;"><i
                        class="fas fa-exclamation-triangle"></i></div>
                <div><small style="color:#888;">Produits en stock faible</small><br><strong>{{ number_format($stockAlerts, 0, ',', ' ') }}</strong></div>
            </div>
            <div class="stat-card-mini">
                <div class="icon-box" style="background:#F3E5F5; color:#7B1FA2;"><i class="fas fa-hourglass-half"></i>
                </div>
                <div><small style="color:#888;">Expiration prochaine</small><br><strong>{{ number_format($expiringProducts, 0, ',', ' ') }}</strong></div>
            </div>
        </div>

        <div class="inventory-card">
            <div class="table-header">
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute; left:12px; top:11px; color:#aaa;"></i>
                    <input type="text" placeholder="Search by product name or ID..."
                        style="width:350px; padding:8px 8px 8px 35px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div style="display:flex; gap:10px;">
                    <select style="padding:8px; border-radius:6px; border:1px solid #ddd;">
                        <option>Toutes les catégories</option>
                    </select>
                    <select style="padding:8px; border-radius:6px; border:1px solid #ddd;">
                        <option>Tous les statuts</option>
                    </select>
                </div>
            </div>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Catégorie</th>
                        <th>Stock</th>
                        <th>Prix</th>
                        <th>Date d'expiration</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicaments as $medicament)
                        @php
                            $statusClass = 'status-instock';
                            $statusText = 'En Stock';
                            if ($medicament->quantite == 0) {
                                $statusClass = 'status-out';
                                $statusText = 'Rupture';
                            } elseif ($medicament->quantite <= $medicament->seuil_alerte) {
                                $statusClass = 'status-low';
                                $statusText = 'Stock Faible';
                            } elseif ($medicament->date_expiration && \Carbon\Carbon::parse($medicament->date_expiration)->isPast()) {
                                $statusClass = 'status-out';
                                $statusText = 'Expiré';
                            } elseif ($medicament->date_expiration && \Carbon\Carbon::parse($medicament->date_expiration)->diffInDays(now()) < 30) {
                                $statusClass = 'status-expiring';
                                $statusText = 'Expiration Proche';
                            }
                        @endphp
                        <tr>
                            <td>
                                <strong>{{ $medicament->nom }}</strong><br>
                                <small style="color:#999;">{{ $medicament->dosage }}</small>
                            </td>
                            <td>-</td> {{-- Catégorie non gérée pour l'instant --}}
                            <td>
                                {{ $medicament->quantite }} <br>
                                <small
                                    style="color:{{ $medicament->quantite <= $medicament->seuil_alerte ? '#c62828' : '#999' }};">
                                    Min: {{ $medicament->seuil_alerte }}
                                </small>
                            </td>
                            <td>{{ number_format($medicament->prix_unitaire, 0, ',', ' ') }} CFA</td>
                            <td>{{ $medicament->date_expiration ? \Carbon\Carbon::parse($medicament->date_expiration)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td><span class="status-pill {{ $statusClass }}">{{ $statusText }}</span></td>
                            <td><i class="fas fa-pen action-icon"></i> <i class="fas fa-trash action-icon"></i></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center; padding: 20px;">Aucun médicament en stock.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</main>
<script src="medilink_pharmacy.js"></script>
</body>

</html>