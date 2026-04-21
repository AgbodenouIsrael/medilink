@extends('layouts.pharmacie')

@section('title', 'Historique des Ventes - Medilink')

@section('content')
    <header style="margin-bottom:25px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="margin:0;">Historique des Ventes</h1>
            <p style="color:#666;">Liste de toutes les transactions passées</p>
        </div>
        <div style="background:white; padding:10px 20px; border-radius:8px; border:1px solid #ddd;">
            <strong>Total Ventes:</strong> {{ $ventes->total() }}
        </div>
    </header>

    <div style="background:white; border-radius:12px; border:1px solid #eee; overflow:hidden;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f9f9f9; text-align:left; color:#666;">
                    <th style="padding:15px; border-bottom:1px solid #eee;">ID Vente</th>
                    <th style="padding:15px; border-bottom:1px solid #eee;">Date</th>
                    <th style="padding:15px; border-bottom:1px solid #eee;">Articles</th>
                    <th style="padding:15px; border-bottom:1px solid #eee;">Montant Total</th>
                    <th style="padding:15px; border-bottom:1px solid #eee;">Détails</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventes as $vente)
                    <tr style="border-bottom:1px solid #eee;">
                        <td style="padding:15px;">#{{ $vente->id }}</td>
                        <td style="padding:15px;">{{ $vente->date_vente->format('d/m/Y H:i') }}</td>
                        <td style="padding:15px;">{{ $vente->details->sum('quantite') }} articles</td>
                        <td style="padding:15px; font-weight:bold; color:#00A651;">
                            {{ number_format($vente->total_montant, 0, ',', ' ') }} CFA
                        </td>
                        <td style="padding:15px;">
                            <button onclick="toggleDetails({{ $vente->id }})"
                                style="background:none; border:none; color:#007bff; cursor:pointer;">
                                Voir détails
                            </button>
                        </td>
                    </tr>
                    <tr id="details-{{ $vente->id }}" style="display:none; background:#fafafa;">
                        <td colspan="5" style="padding:15px;">
                            <div style="padding:10px; border:1px solid #eee; border-radius:8px; background:white;">
                                <h4 style="margin-top:0;">Détails de la vente #{{ $vente->id }}</h4>
                                <ul style="list-style:none; padding:0;">
                                    @foreach($vente->details as $detail)
                                        <li
                                            style="display:flex; justify-content:space-between; padding:5px 0; border-bottom:1px dashed #eee;">
                                            <span>
                                                {{ $detail->quantite }}x
                                                <strong>{{ $detail->medicament->nom ?? 'Produit supprimé' }}</strong>
                                            </span>
                                            <span>{{ number_format($detail->quantite * $detail->prix_unitaire, 0, ',', ' ') }}
                                                CFA</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding:30px; text-align:center; color:#999;">
                            Aucune vente enregistrée pour le moment.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:20px;">
        {{ $ventes->links() }}
    </div>

    <script>
        function toggleDetails(id) {
            const el = document.getElementById('details-' + id);
            if (el.style.display === 'none') {
                el.style.display = 'table-row';
            } else {
                el.style.display = 'none';
            }
        }
    </script>
@endsection