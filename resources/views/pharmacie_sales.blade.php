<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Point de vente - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .pos-container { display: grid; grid-template-columns: 1.8fr 1fr; gap: 20px; }
        
        /* Grille Produits */
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 15px; margin-top: 20px; height: 500px; overflow-y: auto; padding-right: 10px; }
        .product-card { background: white; border: 1px solid #eee; border-radius: 12px; padding: 15px; cursor: pointer; transition: 0.2s; position: relative; }
        .product-card:hover { border-color: var(--primary-green); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .stock-tag { position: absolute; top: 10px; right: 10px; font-size: 11px; color: #888; }
        .product-icon { width: 40px; height: 40px; background: #E8F5E9; color: var(--primary-green); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
        .product-price { color: var(--primary-green); font-weight: 700; font-size: 18px; margin-top: 10px; display: block; }

        /* Panier (Current Sale) */
        .cart-card { background: white; border-radius: 12px; border: 1px solid #eee; height: 100%; display: flex; flex-direction: column; }
        .empty-cart { flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #aaa; text-align: center; padding: 40px; }
        .empty-cart i { font-size: 3em; margin-bottom: 15px; opacity: 0.3; }

        /* Ventes Récentes */
        .recent-sales-card { background: white; border-radius: 12px; border: 1px solid #eee; margin-top: 20px; padding: 0; }
        .sale-item { display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; border-bottom: 1px solid #f5f5f5; }
        .sale-id { font-weight: 600; font-size: 14px; }
        .sale-meta { font-size: 12px; color: #888; }
        .sale-amount { font-weight: 700; color: #333; }
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

    <main class="main-content">
        <header style="margin-bottom:25px;">
            <h1 style="margin:0;">Point de vente</h1>
            <p style="color:#666;">Gérer les ventes et les transactions</p>
        </header>

        <div class="pos-container">
            <div class="selection-area">
                <div style="position:relative;">
                    <i class="fas fa-search" style="position:absolute; left:15px; top:13px; color:#aaa;"></i>
                    <input type="text" placeholder="Search products by name or ID..." style="width:100%; padding:12px 12px 12px 45px; border-radius:8px; border:1px solid #ddd; background: white;">
                </div>

                <div class="product-grid">
                    <div class="product-card">
                        <span class="stock-tag">450 en stock</span>
                        <div class="product-icon"><i class="fas fa-pills"></i></div>
                        <strong>Amoxicillin 500mg</strong><br>
                        <small style="color:#999;">MED-001</small>
                        <span class="product-price">2500 CFA</span>
                    </div>
                    <div class="product-card">
                        <span class="stock-tag">35 en stock</span>
                        <div class="product-icon"><i class="fas fa-pills"></i></div>
                        <strong>Paracetamol 1000mg</strong><br>
                        <small style="color:#999;">MED-002</small>
                        <span class="product-price">800 CFA</span>
                    </div>
                    <div class="product-card">
                        <span class="stock-tag">180 en stock</span>
                        <div class="product-icon"><i class="fas fa-pills"></i></div>
                        <strong>Metformin 850mg</strong><br>
                        <small style="color:#999;">MED-003</small>
                        <span class="product-price">3200 CFA</span>
                    </div>
                    <div class="product-card">
                        <span class="stock-tag">25 en stock</span>
                        <div class="product-icon"><i class="fas fa-pills"></i></div>
                        <strong>Lisinopril 10mg</strong><br>
                        <small style="color:#999;">MED-004</small>
                        <span class="product-price">4500 CFA</span>
                    </div>
                </div>

                <div class="recent-sales-card">
                    <div style="padding:15px 20px; border-bottom:1px solid #eee;"><strong>Ventes Récentes</strong></div>
                    <div class="sale-item">
                        <div>
                            <span class="sale-id">ventes-001</span><br>
                            <small class="sale-meta">Amina Kouassi • 2024-01-15 at 14:32</small>
                        </div>
                        <div style="text-align:right;">
                            <span class="sale-amount">8500 CFA</span><br>
                            <small class="sale-meta">3 articles • Espèces</small>
                        </div>
                    </div>
                    <div class="sale-item">
                        <div>
                            <span class="sale-id">ventes-002</span><br>
                            <small class="sale-meta">Kwame Addo • 2024-01-15 at 13:15</small>
                        </div>
                        <div style="text-align:right;">
                            <span class="sale-amount">5200 CFA</span><br>
                            <small class="sale-meta">2 articles • Mobile Money</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="cart-area">
                <div class="cart-card">
                    <div style="padding:20px; border-bottom:1px solid #eee;"><strong>Ventes Actuel </strong></div>
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <p><strong>Le panier est vide.</strong><br>Ajoutez des produits pour commencer une vente</p>
                    </div>
                    <div style="padding:20px; border-top:1px solid #eee; background: #fafafa; border-radius: 0 0 12px 12px;">
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <span>Subtotal</span><span>0 CFA</span>
                        </div>
                        <div style="display:flex; justify-content:space-between; font-weight:700; font-size:1.2em; margin-bottom:20px;">
                            <span>Total</span><span>0 CFA</span>
                        </div>
                        <button disabled style="width:100%; padding:15px; border-radius:8px; border:none; background:#eee; color:#aaa; font-weight:600; cursor:not-allowed;">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>

    // On stocke les produits du panier ici
let cart = [];
const cartContainer = document.querySelector('.cart-card');
const emptyCartView = document.querySelector('.empty-cart');

// 1. Fonction pour ajouter au panier
document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('click', () => {
        const name = card.querySelector('strong').innerText;
        const priceText = card.querySelector('.product-price').innerText;
        const price = parseInt(priceText.replace(' CFA', ''));
        const id = card.querySelector('small').innerText;

        addToCart(id, name, price);
    });
});

function addToCart(id, name, price) {
    // Vérifier si le produit est déjà là
    const existing = cart.find(item => item.id === id);
    if (existing) {
        existing.qty++;
    } else {
        cart.push({ id, name, price, qty: 1 });
    }
    renderCart();
}

// change quantity of an item
function changeQty(id, delta) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    item.qty += delta;
    if (item.qty <= 0) {
        cart = cart.filter(i => i.id !== id);
    }
    renderCart();
}

function removeItem(id) {
    cart = cart.filter(i => i.id !== id);
    renderCart();
}

// 2. Fonction pour afficher le panier (UI)
function renderCart() {
    if (cart.length > 0) {
        emptyCartView.style.display = 'none';
        
        // On crée la liste des items
        let html = `<div style="padding:20px; border-bottom:1px solid #eee;"><strong>Current Sale</strong></div>`;
        html += `<div style="flex-grow:1; overflow-y:auto; padding:10px;">`;
        
        let total = 0;
        cart.forEach(item => {
            total += item.price * item.qty;
            html += `
                <div style="display:flex; justify-content:space-between; margin-bottom:15px; padding:10px; background:#f9f9f9; border-radius:8px; align-items:center;">
                    <div style="max-width:65%;">
                        <div style="font-weight:600; font-size:14px;">${item.name}</div>
                        <small>${item.price} CFA unité</small>
                        <div style="margin-top:8px; display:flex; gap:8px; align-items:center;">
                            <button onclick="changeQty('${item.id}', -1)" style="padding:6px 8px;border-radius:6px;border:1px solid #ddd;background:white;cursor:pointer;">-</button>
                            <div style="min-width:28px;text-align:center;font-weight:700;">${item.qty}</div>
                            <button onclick="changeQty('${item.id}', 1)" style="padding:6px 8px;border-radius:6px;border:1px solid #ddd;background:white;cursor:pointer;">+</button>
                            <button onclick="removeItem('${item.id}')" style="margin-left:8px;padding:6px 8px;border-radius:6px;border:1px solid #f0f0f0;background:#fff;color:#d32f2f;cursor:pointer;">Suppr</button>
                        </div>
                    </div>
                    <div style="font-weight:700;">${item.price * item.qty} CFA</div>
                </div>`;
        });
        
        html += `</div>`;
        
        // Section Total et Bouton Checkout
        html += `
            <div style="padding:20px; border-top:1px solid #eee; background: #fafafa;">
                <div style="display:flex; justify-content:space-between; font-weight:700; font-size:1.2em; margin-bottom:20px;">
                    <span>Total</span><span>${total} CFA</span>
                </div>
                <button id="checkoutBtn" onclick="processCheckout(${total})" style="width:100%; padding:15px; border-radius:8px; border:none; background:var(--primary-green); color:white; font-weight:600; cursor:pointer;">Checkout</button>
            </div>`;
            
        cartContainer.innerHTML = html;
    }
}

// 3. Bouton Checkout (Simulation)
function processCheckout(total) {
    if (!cart.length) return;
    if (confirm(`Confirmer la vente de ${total} CFA ?`)) {
        // Show a small success overlay animation
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed'; overlay.style.left = 0; overlay.style.top = 0; overlay.style.right = 0; overlay.style.bottom = 0;
        overlay.style.display = 'flex'; overlay.style.alignItems = 'center'; overlay.style.justifyContent = 'center';
        overlay.style.background = 'rgba(0,0,0,0.35)'; overlay.style.zIndex = 1200;
        overlay.innerHTML = `<div style="background:white;padding:30px;border-radius:12px;display:flex;flex-direction:column;align-items:center;gap:10px;"><i class="fas fa-check-circle" style="font-size:48px;color:var(--primary-green);"></i><div style="font-weight:700">Vente enregistrée</div><div style="color:#666">${total} CFA</div></div>`;
        document.body.appendChild(overlay);
        // reset cart
        cart = [];
        renderCart();
        setTimeout(() => { overlay.remove(); }, 1800);
    }
}

// Sélection de l'input de recherche
const searchInput = document.querySelector('input[placeholder*="Search products"]');

searchInput.addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const productCards = document.querySelectorAll('.product-grid .product-card');

    productCards.forEach(card => {
        const productName = card.querySelector('strong').innerText.toLowerCase();
        const productId = card.querySelector('small').innerText.toLowerCase();

        // Si le terme de recherche correspond au nom ou à l'ID
        if (productName.includes(searchTerm) || productId.includes(searchTerm)) {
            card.style.display = 'block'; // On affiche
        } else {
            card.style.display = 'none'; // On cache
        }
    });

    // Optionnel : Message si aucun produit n'est trouvé
    const grid = document.querySelector('.product-grid');
    const existingNoResult = document.getElementById('no-result');
    
    const hasVisibleItems = Array.from(productCards).some(card => card.style.display !== 'none');

    if (!hasVisibleItems) {
        if (!existingNoResult) {
            const msg = document.createElement('div');
            msg.id = 'no-result';
            msg.style.padding = '20px';
            msg.style.color = '#888';
            msg.innerText = "Aucun médicament trouvé...";
            grid.appendChild(msg);
        }
    } else if (existingNoResult) {
        existingNoResult.remove();
    }
});
    </script>
</body>
    </script>
    <script src="medilink_pharmacy.js"></script>

    </body>
</html>