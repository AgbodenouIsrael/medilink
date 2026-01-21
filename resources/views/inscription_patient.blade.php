<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Patient - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le formulaire d'inscription */
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
        }
        .form-title {
            color: var(--color-patient); /* Bleu Patient */
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
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
            <h2 class="form-title"><i class="fas fa-user-injured"></i> Créer un Compte Patient</h2>
            
            @if(session('success'))
                <div style="background:#d4edda;color:#155724;padding:10px;border-radius:6px;margin-bottom:15px;display:flex;gap:8px;align-items:center;">
                    <i class="fas fa-check-circle"></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:6px;margin-bottom:15px;display:flex;gap:8px;align-items:center;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <form action="{{ route('patients.store') }}" method="POST" novalidate>
                @csrf
                
                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="nom"><i class="fas fa-user"></i> Nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" value="{{ old('nom') }}" required>
                        @error('nom') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="prenom"><i class="fas fa-user"></i> Prénom</label>
                        <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" value="{{ old('prenom') }}" required>
                        @error('prenom') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="date_naissance"><i class="fas fa-calendar-alt"></i> Date de Naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance" value="{{ old('date_naissance') }}" required>
                        @error('date_naissance') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="genre"><i class="fas fa-venus-mars"></i> Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">Sélectionner</option>
                            <option value="Homme" {{ old('genre')=='Homme' ? 'selected' : '' }}>Homme</option>
                            <option value="Femme" {{ old('genre')=='Femme' ? 'selected' : '' }}>Femme</option>
                            <option value="Autre" {{ old('genre')=='Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        @error('genre') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="contact"><i class="fas fa-phone"></i> Contact</label>
                        <input type="tel" id="contact" name="contact" placeholder="+228 99 99 99 99" value="{{ old('contact') }}" required>
                        @error('contact') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="adresse"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                        <input type="text" id="adresse" name="adresse" placeholder="12 Rue de la Santé" value="{{ old('adresse') }}" required>
                        @error('adresse') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                   <div class="input-group" style="flex: 1;">
                        <label for="zone_id"><i class="fas fa-globe"></i> Zone</label>
                        <select id="zone_id" name="zone_id" required>
                            <option value="">Sélectionnez votre zone</option>
                            @foreach(\App\Models\Zone::orderBy('ville')->orderBy('nom')->get() as $zone)
                                <option value="{{ $zone->id }}" {{ old('zone_id') == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->nom }} ({{ $zone->ville }})
                                </option>
                            @endforeach
                        </select>
                        @error('zone_id') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Mot de Passe</label>
                    <input type="password" id="password" name="password" required>
                    @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <div class="input-group">
                    <label for="password_confirmation"><i class="fas fa-lock"></i> Confirmer Mot de Passe</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation') <span class="error-msg">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn primary-btn" style="background-color: var(--color-patient);">S'inscrire</button>
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
                            else { if(!el.value || !el.value.toString().trim()){ invalid=true; el.classList.add('input-error'); }}
                        });
                        if(invalid){ e.preventDefault(); const first = form.querySelector('.input-error'); if(first) first.focus(); return; }
                        if(submitBtn){ submitBtn.disabled=true; submitBtn.dataset.orig = submitBtn.innerHTML; submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Chargement...'; }
                    });
                });
            </script>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Déjà un compte ? <a href="{{ route('connexion') }}" style="color: var(--color-primary-blue); text-decoration: none;">Connectez-vous ici.</a>
            </p>
        </main>
    </div>
</body>
</html>