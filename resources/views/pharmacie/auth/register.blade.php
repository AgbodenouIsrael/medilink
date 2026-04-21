<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Pharmacie - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques à cette page d'inscription (Thème Orange) */
        :root {
            --color-pharma: #FF9800;
            --color-pharma-hover: #F57C00;
        }

        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-container {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
        }

        .auth-image {
            background: linear-gradient(135deg, var(--color-pharma), #FFB74D);
            width: 40%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
        }

        .auth-image i {
            font-size: 5em;
            margin-bottom: 20px;
        }

        .auth-form-container {
            width: 60%;
            padding: 40px;
        }

        .auth-form-container h2 {
            color: #333;
            margin-bottom: 10px;
            font-size: 1.8em;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .input-group {
            margin-bottom: 15px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-weight: 500;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1em;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: var(--color-pharma);
            outline: none;
        }

        .input-group.full-width {
            grid-column: 1 / -1;
        }

        .btn-auth {
            background-color: var(--color-pharma);
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 6px;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .btn-auth:hover {
            background-color: var(--color-pharma-hover);
        }

        .auth-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }

        .auth-footer a {
            color: var(--color-pharma);
            text-decoration: none;
            font-weight: bold;
        }

        /* Responsivité */
        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
            }

            .auth-image,
            .auth-form-container {
                width: 100%;
            }

            .auth-image {
                padding: 20px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }
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

    <div class="auth-container">
        <div class="auth-image">
            <i class="fas fa-clinic-medical"></i>
            <h2>Espace Pharmacie</h2>
            <p>Rejoignez le réseau Medilink pour gérer vos stocks et recevoir les ordonnances numériques instantanément.
            </p>
        </div>

        <div class="auth-form-container">
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

            <h2>Inscription Officine</h2>
            <p style="margin-bottom: 25px; color: #777;">Créez votre compte professionnel pour votre pharmacie.</p>

            <form action="{{ route('pharmacie.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="form-grid">
                    <div class="input-group full-width">
                        <label for="pharma_name">Nom de l'Officine</label>
                        <input type="text" id="pharma_name" name="nom_officine" placeholder="Ex: Pharmacie de la Gare"
                            value="{{ old('nom_officine') }}" required>
                        @error('nom_officine') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="pharmacist_name">Pharmacien Titulaire</label>
                        <input type="text" id="pharmacist_name" name="pharmacien_titulaire" placeholder="Dr. Nom Prénom"
                            value="{{ old('pharmacien_titulaire') }}" required>
                        @error('pharmacien_titulaire') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="license_id">N° Licence / Agrément</label>
                        <input type="text" id="license_id" name="numero_licence" placeholder="Ex: PH-123456"
                            value="{{ old('numero_licence') }}" required>
                        @error('numero_licence') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group full-width">
                        <label for="fichier_licence">Document de Licence / Agrément (PDF, JPG, PNG)</label>
                        <input type="file" id="fichier_licence" name="fichier_licence" required
                            accept=".pdf,.jpg,.jpeg,.png">
                        <small style="color: #888;">Ce document est requis pour la validation de votre compte par
                            l'administrateur.</small>
                        @error('fichier_licence') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="address">Adresse Complète</label>
                        <input type="text" id="address" name="adresse_complete" placeholder="Rue, Quartier"
                            value="{{ old('adresse_complete') }}" required>
                        @error('adresse_complete') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="zone_id">Ville / Zone</label>
                        <select id="zone_id" name="zone_id" required
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">Sélectionner une zone</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->nom }} ({{ $zone->ville }})
                                </option>
                            @endforeach
                        </select>
                        @error('zone_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="email">Email Professionnel</label>
                        <input type="email" id="email" name="email" placeholder="contact@pharmacie.com"
                            value="{{ old('email') }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="telephone" placeholder="+228..."
                            value="{{ old('telephone') }}" required>
                        @error('telephone') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" id="password" name="password" required>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="confirm_password">Confirmer Mot de passe</label>
                        <input type="password" id="confirm_password" name="password_confirmation" required>
                        @error('password_confirmation') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="input-group full-width" style="margin-top: 10px;">
                    <label style="display: flex; align-items: start; gap: 10px; cursor: pointer;">
                        <input type="checkbox" id="privacy_policy" name="privacy_policy" required disabled
                            style="width: auto; margin-top: 3px;">
                        <span style="font-size: 0.9em;">
                            J'atteste être un pharmacien agréé et j'accepte la <a href="{{ route('privacy.policy') }}"
                                target="_blank" id="privacy_link"
                                style="color:var(--color-pharma); text-decoration: underline;">Politique de
                                Confidentialité</a>.
                        </span>
                    </label>
                    <small style="display: block; color: #666; margin-left: 25px; font-size: 0.8em;">Veuillez cliquer
                        sur le lien pour lire la politique avant d'accepter.</small>
                    @error('privacy_policy') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <script>
                    const pLink = document.getElementById('privacy_link');
                    const pCheck = document.getElementById('privacy_policy');
                    if (pLink && pCheck) {
                        pLink.addEventListener('click', function () {
                            pCheck.disabled = false;
                        });
                    }
                </script>

                <button type="submit" class="btn-auth">Créer mon compte Pharmacie</button>
            </form>

            <div class="auth-footer">
                <p>Vous avez déjà un compte ? <a href="{{ route('login.submit') }}">Se connecter</a></p>
                <p style="margin-top: 10px;"><a href="{{ route('login.submit') }}"><i class="fas fa-arrow-left"></i>
                        Retour à
                        l'accueil</a></p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form[method="POST"]');
            if (!form) return;
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function (e) {
                // clear previous errors
                form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
                let invalid = false;

                form.querySelectorAll('[required]').forEach(function (el) {
                    if (el.type === 'checkbox') {
                        if (!el.checked) { invalid = true; el.classList.add('input-error'); }
                    } else {
                        if (!el.value || !el.value.toString().trim()) { invalid = true; el.classList.add('input-error'); }
                    }
                });

                // password confirmation
                const pw = form.querySelector('[name="password"]');
                const pwc = form.querySelector('[name="password_confirmation"]');
                if (pw && pwc) {
                    if (pw.value !== pwc.value) {
                        invalid = true;
                        pw.classList.add('input-error');
                        pwc.classList.add('input-error');
                        let err = pwc.parentNode.querySelector('.js-pw-error');
                        if (!err) { err = document.createElement('span'); err.className = 'error-msg js-pw-error'; pwc.parentNode.appendChild(err); }
                        err.textContent = 'Les mots de passe ne correspondent pas.';
                    } else {
                        const err = form.querySelector('.js-pw-error'); if (err) err.remove();
                    }
                }

                if (invalid) {
                    e.preventDefault();
                    const first = form.querySelector('.input-error'); if (first) first.focus();
                    return;
                }

                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.dataset.orig = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...';
                }
            });
        });
    </script>

</body>

</html>