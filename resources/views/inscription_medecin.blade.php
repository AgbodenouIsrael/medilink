<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Médecin - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css' ) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles spécifiques pour le formulaire d'inscription Médecin */
        .registration-container {
            max-width: 600px;
            margin: 50px auto;
        }
        .form-title {
            color: var(--color-medecin); /* Vert Médecin */
            text-align: center;
            margin-bottom: 20px;
            font-weight: 300;
        }
        /* Style pour les champs de fichier */
        .input-group input[type="file"] {
            padding: 10px 15px;
            /* Le reste du style est hérité de style.css */
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
            
            <form action="{{ route('dashboard_medecin') }}" method="POST" enctype="multipart/form-data">
                
                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="nom_m"><i class="fas fa-user"></i> Nom</label>
                        <input type="text" id="nom_m" name="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="prenom_m"><i class="fas fa-user"></i> Prénom</label>
                        <input type="text" id="prenom_m" name="prenom" placeholder="Votre prénom" required>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="contact_m"><i class="fas fa-phone"></i> Contact</label>
                        <input type="tel" id="contact_m" name="contact" placeholder="+33 6 12 34 56 78" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="email_m"><i class="fas fa-envelope"></i> Email Professionnel</label>
                        <input type="email" id="email_m" name="email" placeholder="pro@medilink.com" required>
                    </div>
                </div>
                
                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="specialite_id"><i class="fas fa-stethoscope"></i> Spécialité</label>
                        <select id="specialite_id" name="specialite_id" required>
                            <option value="">Sélectionner votre spécialité</option>
                            <option value="pediatrie">Pédiatrie</option>
                            <option value="cardiologie">Cardiologie</option>
                            <option value="dermatologie">Dermatologie</option>
                            </select>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="mot_de_passe_m"><i class="fas fa-lock"></i> Mot de Passe</label>
                        <input type="password" id="mot_de_passe_m" name="mot_de_passe" required>
                    </div>
                </div>

                <div class="input-group">
                    <label for="certificat"><i class="fas fa-file-pdf"></i> Certificat d'Exercice (PDF/Image)</label>
                    <input type="file" id="certificat" name="certificat" accept=".pdf, .jpg, .png" required>
                    <small>Ce fichier sera vérifié pour valider votre compte.</small>
                </div>
                
                <button type="submit" class="btn primary-btn" style="background-color: var(--color-medecin);">S'inscrire comme Médecin</button>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Vous êtes un patient ? <a href="{{ route('inscription_patient') }}" style="color: var(--color-primary-blue); text-decoration: none;">Inscrivez-vous ici.</a>
            </p>
        </main>
    </div>
</body>
</html>