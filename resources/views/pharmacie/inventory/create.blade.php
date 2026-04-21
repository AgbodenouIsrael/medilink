<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Ajouter un nouveau produit - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/pharmacie_layout.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .form-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #eee;
            padding: 25px;
            margin-bottom: 25px;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #f5f5f5;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: 0.2s;
            box-sizing: border-box;
        }

        .form-group input:focus {
            border-color: #FF6600;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            right: 12px;
            top: 14px;
            color: #aaa;
            cursor: pointer;
        }

        .btn-group {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-cancel {
            background: #f5f5f5;
            color: #666;
            border: 1px solid #ddd;
            padding: 12px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        .btn-submit {
            background: #FF6600;
            /* Orange */
            color: white;
            border: none;
            padding: 15px 40px;
            /* Larger padding */
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            font-size: 16px;
            /* Larger font */
            box-shadow: 0 4px 6px rgba(255, 102, 0, 0.2);
            /* Shadow for prominence */
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #e65c00;
            transform: translateY(-2px);
            box-shadow: 0 6px 8px rgba(255, 102, 0, 0.3);
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
        <div class="form-container">
            <header style="margin-bottom:30px; display: flex; align-items: center; gap: 15px;">
                <a href="{{ route('pharmacie.inventory') }}" style="color: #666; text-decoration: none;"><i
                        class="fas fa-arrow-left"></i></a>
                <div>
                    <h1 style="margin:0; font-size: 24px;">Ajouter un nouveau médicament</h1>
                    <p style="color:#666;">Entrez les détails du produit pour mettre à jour votre inventaire numérique.
                    </p>
                </div>
            </header>

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

            <form action="{{ url()->current() }}" method="POST" novalidate>
                @csrf
                <div class="form-grid">
                    <div class="left-col">
                        <div class="form-card">
                            <div class="form-section-title"><i class="fas fa-info-circle"></i> Informations générales
                            </div>

                            <div class="form-group">
                                <label>Nom du produit *</label>
                                <input type="text" name="nom" placeholder="e.g. Paracetamol 500mg"
                                    value="{{ old('nom') }}" required>
                                @error('nom') <span class="error-msg">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Dosage *</label>
                                <input type="text" name="dosage" placeholder="e.g. 500mg" value="{{ old('dosage') }}"
                                    required>
                                @error('dosage') <span class="error-msg">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Categorie</label>
                                <select name="categorie">
                                    <option value="">Selectionez Categorie</option>
                                    <option value="antibiotique" {{ old('categorie') == 'antibiotique' ? 'selected' : '' }}>Antibiotique</option>
                                    <option value="antalgique" {{ old('categorie') == 'antalgique' ? 'selected' : '' }}>
                                        Antalgique</option>
                                    <option value="cardiovasculaire" {{ old('categorie') == 'cardiovasculaire' ? 'selected' : '' }}>Cardiovasculaire</option>
                                    <option value="pediatrique" {{ old('categorie') == 'pediatrique' ? 'selected' : '' }}>
                                        Pédiatrique</option>
                                    <!-- Ajouter d'autres catégories si nécessaire dans le futur -->
                                </select>
                                <small>Note: La catégorie n'est pas encore stockée.</small>
                            </div>

                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" rows="3"
                                    placeholder="Additional notes, molecules, etc.">{{ old('description') }}</textarea>
                                @error('description') <span class="error-msg">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="right-col">
                        <div class="form-card">
                            <div class="form-section-title"><i class="fas fa-tags"></i> Tarification & Stock</div>

                            <div class="form-grid" style="grid-template-columns: 1fr; gap: 15px;">
                                <div class="form-group">
                                    <label>Prix Unitaire (CFA) *</label>
                                    <input type="number" name="prix_unitaire" step="1" placeholder="0"
                                        value="{{ old('prix_unitaire') }}" required>
                                    @error('prix_unitaire') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-grid" style="grid-template-columns: 1fr 1fr; gap: 15px;">
                                <div class="form-group">
                                    <label>Quantité initiale *</label>
                                    <input type="number" name="quantite" placeholder="0"
                                        value="{{ old('quantite', 0) }}" required>
                                    @error('quantite') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                                <div class="form-group">
                                    <label>Alerte de stock minimum</label>
                                    <input type="number" name="seuil_alerte" value="{{ old('seuil_alerte', 10) }}">
                                    @error('seuil_alerte') <span class="error-msg">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Date d'expiration</label>
                                <input type="date" name="date_expiration" value="{{ old('date_expiration') }}">
                                @error('date_expiration') <span class="error-msg">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-card" style="background: #f0fdf4; border-color: #c8e6c9;">
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <div>
                                    <strong style="color: #2e7d32;">Visible sur l'application Medilink</strong><br>
                                    <small style="color: #666;">Autoriser les patients à consulter ce produit</small>
                                </div>
                                <label class="switch"
                                    style="position: relative; display: inline-block; width: 44px; height: 22px;">
                                    <input type="checkbox" name="visible" value="1" {{ old('visible', '1') ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                                    <span
                                        style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .4s; border-radius: 34px;"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="btn-group">
                    <button type="button" class="btn-cancel" onclick="history.back()">Annuler</button>
                    <button type="submit" class="btn-submit">Enregistrer le produit</button>
                </div>
            </form>
        </div>
    </main>

    <div id="successToast"
        style="display: none; position: fixed; top: 20px; right: 20px; background: #2e7d32; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); z-index: 1000; animation: slideIn 0.3s ease-out;">
        <i class="fas fa-check-circle" style="margin-right: 10px;"></i> Produit enregistré avec succès !
    </div>

    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[method="POST"]');
            if (!form) return;
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function (e) {
                // disable submit and show spinner
                if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enregistrement...'; }
            });

            // barcode scanner simulation
            const barcodeIcon = document.querySelector('.fa-barcode');
            if (barcodeIcon) {
                barcodeIcon.addEventListener('click', function () {
                    const barcodeInput = this.previousElementSibling;
                    if (barcodeInput) { barcodeInput.value = '6131234567890'; barcodeInput.style.backgroundColor = '#e8f5e9'; setTimeout(() => barcodeInput.style.backgroundColor = 'white', 500); }
                });
            }
        });
    </script>
    <script src="medilink_pharmacy.js"></script>

</body>

</html>