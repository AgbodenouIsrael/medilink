<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medilink - Connexion / Inscription</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .error-msg { color: #dc3545; font-size: 0.85em; margin-top: 4px; display: block; }
        .input-error { border-color: #dc3545 !important; }
    </style>
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </header>

        <main class="auth-section">
            <div class="card login-card">
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
                <h2>Connexion</h2>
                <form action="{{ route('login.submit') }}" method="POST" >
                    @csrf
                    <div class="input-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" placeholder="votre@email.com" value="{{ old('email') }}" required>
                        @error('email') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group">
                            <label for="password"><i class="fas fa-lock"></i> Mot de passe</label>
                            <input type="password" id="password" name="password" required>
                        @error('password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                    <div class="input-group" style="display:flex;align-items:center;gap:8px;">
                        <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" style="margin:0;">Se souvenir de moi</label>
                    </div>
                    <button type="submit" class="btn primary-btn">Se connecter</button>
                </form>
            </div>

            <div class="card register-card">
                <h2>Créer un compte</h2>
                <p>Choisissez votre type de compte pour vous inscrire sur MediLink :</p>
                <div class="register-choices">
                    <a href="{{ route('inscription_patient') }}" class="btn register-btn patient-btn">
                        <i class="fas fa-user-injured"></i> Patient
                    </a>
                    <a href="{{ route('inscription_medecin') }}" class="btn register-btn medecin-btn">
                        <i class="fas fa-user-md"></i> Médecin
                    </a>
                    <a href="{{ route('inscription_hopitaux') }}" class="btn register-btn hopital-btn">
                        <i class="fas fa-hospital"></i> Hôpital
                    </a>

                    <a href="{{ route('inscription_pharmacie') }}" class="btn primary-btn" style="background-color: #FF9800; width:100%;">Pharmacie</a>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function(){
            const form = document.querySelector('form[action="{{ route('login.submit') }}"]');
            if(!form) return;
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
</body>
</html>