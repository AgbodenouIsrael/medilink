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
    </style>
</head>
<body>
    <div class="container registration-container">
        <header class="header">
            <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        </header>

        <main class="card">
            <h2 class="form-title"><i class="fas fa-hospital"></i> Créer un Compte Hôpital</h2>
            
            <form action="{{ route('dashboard_hopital') }}" method="POST" enctype="multipart/form-data">
                
                <div class="input-group">
                    <label for="nom_hopital"><i class="fas fa-building"></i> Nom de l'Hôpital / Clinique</label>
                    <input type="text" id="nom_hopital" name="nom_hopital" placeholder="Hôpital Central de [Ville]" required>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="adresse_h"><i class="fas fa-map-marker-alt"></i> Adresse</label>
                        <input type="text" id="adresse_h" name="adresse" placeholder="12 Rue Principale" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="zone_h"><i class="fas fa-globe"></i> Ville/Zone</label>
                        <input type="text" id="zone_h" name="zone" placeholder="Paris, Lomé, etc." required>
                    </div>
                </div>

                <div style="display: flex; gap: 20px;">
                    <div class="input-group" style="flex: 1;">
                        <label for="email_h"><i class="fas fa-envelope"></i> Email Institutionnel</label>
                        <input type="email" id="email_h" name="email" placeholder="contact@hopital.com" required>
                    </div>
                    <div class="input-group" style="flex: 1;">
                        <label for="contact_h"><i class="fas fa-phone"></i> Contact (Téléphone)</label>
                        <input type="tel" id="contact_h" name="contact" placeholder="+33 1 23 45 67 89" required>
                    </div>
                </div>
                
                <div class="input-group">
                    <label for="fichier_enregistrement"><i class="fas fa-file-signature"></i> Fichier d'Enregistrement Légal (PDF/Image)</label>
                    <input type="file" id="fichier_enregistrement" name="fichier_enregistrement" accept=".pdf, .jpg, .png" required>
                    <small>Ce document est nécessaire pour la validation de votre établissement.</small>
                </div>

                <div class="input-group">
                    <label for="mot_de_passe_h"><i class="fas fa-lock"></i> Mot de Passe (Administrateur)</label>
                    <input type="password" id="mot_de_passe_h" name="mot_de_passe" required>
                </div>
                
              <a href="">  <button  type="submit" class="btn primary-btn" style="background-color: var(--color-hopital);">Enregistrer l'Hôpital</button> </a>
            </form>

            <p style="text-align: center; margin-top: 20px; font-size: 0.9em;">
                Vous êtes un médecin ? <a href="{{ route('inscription_medecin') }}" style="color: var(--color-primary-blue); text-decoration: none;">Inscrivez-vous ici.</a>
            </p>
        </main>
    </div>
</body>
</html>