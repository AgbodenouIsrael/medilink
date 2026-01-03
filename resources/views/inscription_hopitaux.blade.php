<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Hôpital - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le formulaire d'inscription Hôpital */
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
        }
        .form-title {
            color: var(--color-hopital); /* Violet Hôpital */
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
        }
        /* Style pour les champs de fichier */
        .input-group input[type="file"] {
            padding: 10px 15px;
        }
        .error-msg { color: #dc3545; font-size: 0.85em; margin-top: 4px; display: block; }
        .input-error { border-color: #dc3545 !important; }
    </style>
</head>
<body>
    <div class="container registration-container">
        <header class="header">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </header>

        <main class="card">
            <h2 class="form-title"><i class="fas fa-hospital"></i> Créer un Compte Hôpital</h2>
            
            <form action="{{ route('dashboard_hopital') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                
                <div class="input-group">
                    <label for="nom_hopital"><i class="fas fa-building"></i> Nom de l'Hôpital / Clinique</label>
                    <input type="text" id="nom_hopital" name="nom_hopital" placeholder="Hôpital Central de [Ville]" value="{{ old('nom_hopital') }}" required>
                    @error('nom_hopital') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="adresse_h"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                        <input type="text" id="adresse_h" name="adresse" placeholder="12 Rue Principale" value="{{ old('adresse') }}" required>
                        @error('adresse') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="zone_h"><i class="fas fa-globe"></i> Ville/Zone</label>
                        <input type="text" id="zone_h" name="zone" placeholder="Paris, Lomé, etc." value="{{ old('zone') }}" required>
                        @error('zone') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="email_h"><i class="fas fa-envelope"></i> Email Institutionnel</label>
                        <input type="email" id="email_h" name="email" placeholder="contact@hopital.com" value="{{ old('email') }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="contact_h"><i class="fas fa-phone"></i> Contact (Téléphone)</label>
                        <input type="tel" id="contact_h" name="contact" placeholder="+33 1 23 45 67 89" value="{{ old('contact') }}" required>
                        @error('contact') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="fichier_enregistrement"><i class="fas fa-file-signature"></i> Fichier d'Enregistrement Légal (PDF/Image)</label>
                    <input type="file" id="fichier_enregistrement" name="fichier_enregistrement" accept=".pdf, .jpg, .png" required>
                    @error('fichier_enregistrement') <span class="error-msg">{{ $message }}</span> @enderror
                    <small>Ce document est nécessaire pour la validation de votre établissement.</small>
                </div>

                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Mot de Passe (Administrateur)</label>
                    <input type="password" id="password" name="password" required>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-hopital);">Enregistrer l'Hôpital</button>
            </form>

            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    const form = document.querySelector('form[method="POST"]'); if(!form) return;
                    const submitBtn = form.querySelector('button[type="submit"]');
                    form.addEventListener('submit', function(e){
                        form.querySelectorAll('.input-error').forEach(el=>el.classList.remove('input-error'));
                        let invalid=false;
                        form.querySelectorAll('[required]').forEach(function(el){
                            if(el.type==='checkbox'){ if(!el.checked){ invalid=true; el.classList.add('input-error'); }}
                            else { if(el.type==='file'){ if(!el.files || el.files.length===0){ invalid=true; el.classList.add('input-error'); }} else if(!el.value || !el.value.toString().trim()){ invalid=true; el.classList.add('input-error'); }}
                        });
                        if(invalid){ e.preventDefault(); const first = form.querySelector('.input-error'); if(first) first.focus(); return; }
                        if(submitBtn){ submitBtn.disabled=true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...'; }
                    });
                });
            </script>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Vous êtes un médecin ? <a href="{{ route('inscription_medecin') }}" style="color: var(--color-primary-blue); text-decoration: none;">Inscrivez-vous ici.</a>
            </p>
        </main>
    </div>
</body>
</html>