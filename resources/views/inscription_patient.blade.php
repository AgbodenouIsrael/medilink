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
    </style>
</head>
<body>
    <div class="container registration-container">
        <header class="header">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </header>

        <main class="card">
            <h2 class="form-title"><i class="fas fa-user-injured"></i> Créer un Compte Patient</h2>
            
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                
                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="nom"><i class="fas fa-user"></i> Nom</label>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="prenom"><i class="fas fa-user"></i> Prénom</label>
                        <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="date_naissance"><i class="fas fa-calendar-alt"></i> Date de Naissance</label>
                        <input type="date" id="date_naissance" name="date_naissance" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="genre"><i class="fas fa-venus-mars"></i> Genre</label>
                        <select id="genre" name="genre" required>
                            <option value="">Sélectionner</option>
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="contact"><i class="fas fa-phone"></i> Contact</label>
                        <input type="tel" id="contact" name="contact" placeholder="+33 6 12 34 56 78" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" placeholder="votre@email.com" required>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="adresse"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                        <input type="text" id="adresse" name="adresse" placeholder="12 Rue de la Santé" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="zone"><i class="fas fa-globe"></i> Ville/Zone</label>
                        <input type="text" id="zone" name="zone" placeholder="Paris, Lomé, etc." required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="mot_de_passe"><i class="fas fa-lock"></i> Mot de Passe</label>
                    <input type="password" id="mot_de_passe" name="mot_de_passe" required>
                </div>
                
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-patient);">S'inscrire</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Déjà un compte ? <a href="{{ route('connexion') }}" style="color: var(--color-primary-blue); text-decoration: none;">Connectez-vous ici.</a>
            </p>
        </main>
    </div>
</body>
</html>