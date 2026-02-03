<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Politique de Confidentialité - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .policy-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
        }

        .policy-header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 20px;
        }

        .policy-header h1 {
            color: var(--color-primary-blue, #0056b3);
            margin-bottom: 10px;
        }

        .policy-section {
            margin-bottom: 30px;
        }

        .policy-section h2 {
            color: var(--color-dark, #2c3e50);
            font-size: 1.4rem;
            margin-bottom: 15px;
        }

        .policy-section ul {
            padding-left: 20px;
        }

        .policy-section li {
            margin-bottom: 10px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: var(--color-primary-blue, #0056b3);
            font-weight: 600;
        }

        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="policy-container">
        <header class="policy-header">
            <h1><i class="fas fa-shield-alt"></i> Politique de Confidentialité</h1>
            <p>Dernière mise à jour : {{ date('d/m/Y') }}</p>
        </header>

        <section class="policy-section">
            <h2>1. Introduction</h2>
            <p>Bienvenue sur Medilink. La confidentialité de vos données est notre priorité absolue. Cette politique
                explique comment nous collectons, utilisons, partageons et protégeons vos informations personnelles
                lorsque vous utilisez notre plateforme de santé.</p>
        </section>

        <section class="policy-section">
            <h2>2. Données Collectées</h2>
            <p>Nous collectons les types de données suivants pour assurer le bon fonctionnement de nos services :</p>
            <ul>
                <li><strong>Informations d'identification :</strong> Nom, prénom, date de naissance, adresse email,
                    numéro de téléphone.</li>
                <li><strong>Données de santé :</strong> Antécédents médicaux, ordonnances, résultats d'examens (cryptés
                    et sécurisés).</li>
                <li><strong>Données techniques :</strong> Adresse IP, type de navigateur, journaux de connexion pour la
                    sécurité.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>3. Utilisation des Données</h2>
            <p>Vos données sont utilisées exclusivement pour :</p>
            <ul>
                <li>Faciliter la prise de rendez-vous et la gestion de vos soins.</li>
                <li>Permettre aux professionnels de santé autorisés d'accéder à votre dossier médical.</li>
                <li>Améliorer la sécurité et les fonctionnalités de la plateforme.</li>
                <li>Nous ne vendons jamais vos données personnelles à des tiers.</li>
            </ul>
        </section>

        <section class="policy-section">
            <h2>4. Sécurité des Données</h2>
            <p>Nous mettons en œuvre des mesures de sécurité techniques et organisationnelles robustes, incluant le
                chiffrement des données sensibles, des pare-feu avancés et des contrôles d'accès stricts.</p>
        </section>

        <section class="policy-section">
            <h2>5. Vos Droits</h2>
            <p>Conformément à la réglementation en vigueur, vous disposez d'un droit d'accès, de rectification, de
                suppression et de portabilité de vos données. Vous pouvez exercer ces droits depuis votre espace
                personnel ou en nous contactant.</p>
        </section>

        <section class="policy-section">
            <h2>6. Cookies</h2>
            <p>Nous utilisons des cookies essentiels pour le fonctionnement sécurisé du site. Aucun cookie publicitaire
                tiers n'est utilisé sans votre consentement explicite.</p>
        </section>

        <div style="text-align: center; margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px;">
            <p>En utilisant Medilink, vous acceptez les termes de cette politique de confidentialité.</p>
            <a href="javascript:window.close()" class="back-btn"><i class="fas fa-times"></i> Fermer cette page</a>
        </div>
    </div>
</body>

</html>