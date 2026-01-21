<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Médecin - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le formulaire d'inscription Médecin */
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
        }

        .form-title {
            color: var(--color-medecin);
            /* Vert Médecin */
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
        }

        /* Style pour les champs de fichier */
        .input-group input[type="file"] {
            padding: 10px 15px;
            /* Le reste du style est hérité de style.css */
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
    <div class="container registration-container">
        <header class="header">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </header>

        <main class="card">
            <h2 class="form-title"><i class="fas fa-user-md"></i> Créer un Compte Médecin</h2>

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

            <form action="{{ route('medecin.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="nom_m"><i class="fas fa-user"></i> Nom</label>
                        <input type="text" id="nom_m" name="nom" placeholder="Votre nom" value="{{ old('nom') }}"
                            required>
                        @error('nom') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="prenom_m"><i class="fas fa-user"></i> Prénom</label>
                        <input type="text" id="prenom_m" name="prenom" placeholder="Votre prénom"
                            value="{{ old('prenom') }}" required>
                        @error('prenom') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="contact_m"><i class="fas fa-phone"></i> Contact</label>
                        <input type="tel" id="contact_m" name="contact" placeholder="+228 99 99 99 99"
                            value="{{ old('contact') }}" required>
                        @error('contact') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="email_m"><i class="fas fa-envelope"></i> Email Professionnel</label>
                        <input type="email" id="email_m" name="email" placeholder="pro@medilink.com"
                            value="{{ old('email') }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="specialite_id"><i class="fas fa-stethoscope"></i> Spécialité</label>
                        <select id="specialite_id" name="specialite_id" required>
                            <option value="">Sélectionner votre spécialité</option>
                            @foreach($specialites as $specialite)
                                <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                    {{ $specialite->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialite_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="numero_licence"><i class="fas fa-id-card"></i> Numéro de Licence</label>
                        <input type="text" id="numero_licence" name="numero_licence" placeholder="LIC-12345"
                            value="{{ old('numero_licence') }}" required>
                        @error('numero_licence') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="password"><i class="fas fa-lock"></i> Mot de Passe</label>
                        <input type="password" id="password" name="password" required>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmer Mot de Passe</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="certificat"><i class="fas fa-file-pdf"></i> Certificat d'Exercice (PDF/Image)</label>
                    <input type="file" id="certificat" name="certificat_path" accept=".pdf, .jpg, .png" required>
                    @error('certificat_path') <span class="error-msg">{{ $message }}</span> @enderror
                    <small>Ce fichier sera vérifié pour valider votre compte.</small>
                </div>

                <button type="submit" class="btn primary-btn" style="background-color: var(--color-medecin);">S'inscrire
                    comme Médecin</button>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.querySelector('form[method="POST"]'); if (!form) return;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    form.addEventListener('submit', function (e) {
                        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
                        let invalid = false;
                        form.querySelectorAll('[required]').forEach(function (el) {
                            if (el.type === 'file') { if (!el.files || el.files.length === 0) { invalid = true; el.classList.add('input-error'); } }
                            else if (el.type === 'checkbox') { if (!el.checked) { invalid = true; el.classList.add('input-error'); } }
                            else { if (!el.value || !el.value.toString().trim()) { invalid = true; el.classList.add('input-error'); } }
                        });
                        if (invalid) { e.preventDefault(); const first = form.querySelector('.input-error'); if (first) first.focus(); return; }
                        if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...'; }
                    });
                });
            </script>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Vous êtes un patient ? <a href="{{ route('inscription_patient') }}"
                    style="color: var(--color-primary-blue); text-decoration: none;">Inscrivez-vous ici.</a>
            </p>
        </main>
    </div>
</body>

</html>