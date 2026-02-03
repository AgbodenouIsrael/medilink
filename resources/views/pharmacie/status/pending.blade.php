<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Attente de Validation - MediLink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --color-pharma: #FF9800;
        }

        .pending-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f7f6;
            text-align: center;
            padding: 20px;
        }

        .pending-card {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }

        .icon-pending {
            font-size: 4em;
            color: var(--color-pharma);
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 15px;
            color: #333;
        }

        p {
            color: #666;
            font-size: 1.1em;
            line-height: 1.6;
        }

        .btn-home {
            margin-top: 30px;
            display: inline-block;
            background: var(--color-pharma);
            color: white;
            padding: 10px 25px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-home:hover {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="pending-container">
        <div class="pending-card">
            <i class="fas fa-prescription-bottle-alt icon-pending"></i>
            <h2>En Attente de Validation</h2>
            <p>Merci d'avoir inscrit votre pharmacie sur MediLink.</p>
            <p>Votre compte est actuellement en cours d'examen par nos administrateurs. Vous pourrez accéder à votre
                tableau de bord dès que votre accès sera activé.</p>

            <form action="{{ route('logout.pharmacie') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn-home" style="border:none; cursor:pointer;">Retour à l'accueil</button>
            </form>
        </div>
    </div>
</body>

</html>