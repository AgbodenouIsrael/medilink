<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medilink - Connexion / Inscription</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </header>

        <main class="auth-section">
            <div class="card login-card">
                <h2>Connexion</h2>
                <form action="{{ route('login.submit') }}" method="POST" >
                    @csrf
                    <div class="input-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" placeholder="votre@email.com" required>
                    </div>
                    <div class="input-group">
                        <label for="mot_de_passe"><i class="fas fa-lock"></i> Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
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
                </div>
            </div>
        </main>
    </div>
</body>
</html>