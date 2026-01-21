<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Hôpital - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le formulaire d'inscription Hôpital */
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
        }

        .form-title {
            color: var(--color-hopital);
            /* Violet Hôpital */
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
        }

        /* Style pour les champs de fichier */
        .input-group input[type="file"] {
            padding: 10px 15px;
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
            <h2 class="form-title"><i class="fas fa-hospital"></i> Créer un Compte Hôpital</h2>

            <form action="{{ route('hopital.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="input-group">
                    <label for="nom"><i class="fas fa-building"></i> Nom de l'Hôpital / Clinique</label>
                    <input type="text" id="nom" name="nom" placeholder="Hôpital Central de [Ville]"
                        value="{{ old('nom') }}" required>
                    @error('nom') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="adresse_h"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                        <input type="text" id="adresse_h" name="adresse" placeholder="Agoe"
                            value="{{ old('adresse') }}" required>
                        @error('adresse') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="zone_id"><i class="fas fa-globe"></i> Ville/Zone</label>
                        <select id="zone_id" name="zone_id" required
                            style="width: 100%; padding: 10px; border-radius: 5px; border: 1px solid #ccc;">
                            <option value="">Sélectionner une zone</option>
                            @foreach($zones as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->nom }} ({{ $zone->ville }})</option>
                            @endforeach
                        </select>
                        @error('zone_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="email_h"><i class="fas fa-envelope"></i> Email Institutionnel</label>
                        <input type="email" id="email_h" name="email" placeholder="contact@hopital.com"
                            value="{{ old('email') }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="contact_h"><i class="fas fa-phone"></i> Contact (Téléphone)</label>
                        <input type="tel" id="contact_h" name="contact" placeholder="+228 99 99 99 99"
                            value="{{ old('contact') }}" required>
                        @error('contact') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="input-group">
                    <label for="fichier_enregistrement"><i class="fas fa-file-signature"></i> Fichier d'Enregistrement
                        Légal (PDF/Image)</label>
                    <input type="file" id="fichier_enregistrement" name="fichier_enregistrement_path"
                        accept=".pdf, .jpg, .png" required>
                    @error('fichier_enregistrement_path') <span class="error-msg">{{ $message }}</span> @enderror
                    <small>Ce document est nécessaire pour la validation de votre établissement.</small>
                </div>

                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Mot de Passe (Administrateur)</label>
                    <input type="password" id="password" name="password" required>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmer le Mot de Passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn primary-btn"
                    style="background-color: var(--color-hopital);">Enregistrer l'Hôpital</button>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const form = document.querySelector('form[method="POST"]'); if (!form) return;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    form.addEventListener('submit', function (e) {
                        form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
                        let invalid = false;
                        form.querySelectorAll('[required]').forEach(function (el) {
                            if (el.type === 'checkbox') { if (!el.checked) { invalid = true; el.classList.add('input-error'); } }
                            else { if (el.type === 'file') { if (!el.files || el.files.length === 0) { invalid = true; el.classList.add('input-error'); } } else if (!el.value || !el.value.toString().trim()) { invalid = true; el.classList.add('input-error'); } }
                        });
                        if (invalid) { e.preventDefault(); const first = form.querySelector('.input-error'); if (first) first.focus(); return; }
                        if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...'; }
                    });
                });
            </script>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Vous êtes un médecin ? <a href="{{ route('inscription_medecin') }}"
                    style="color: var(--color-primary-blue); text-decoration: none;">Inscrivez-vous ici.</a>
            </p>
        </main>
    </div>
</body>

</html>