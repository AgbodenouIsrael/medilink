<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>En Attente de Validation - MediLink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet">
    <style>
        :root {
            --color-medecin: #4F46E5;
            /* Indigo */
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
            color: var(--color-medecin);
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
            background: var(--color-medecin);
            color: white;
            padding: 10px 25px;
            border-radius: 6px;
            text-decoration: none;
            transition: 0.3s;
        }

        .btn-home:hover {
            opacity: 0.9;
        }

        .info-box {
            background: #eef2ff;
            border: 1px solid #e0e7ff;
            color: #3730a3;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <div class="pending-container">
        <div class="pending-card">
            <i class="fas fa-user-md icon-pending"></i>
            <h2>Votre compte est en cours d'examen</h2>

            <p>Merci de votre inscription, Dr. {{ Auth::guard('medecin')->user()->nom }}.</p>
            <p>Votre dossier est actuellement analysé par nos administrateurs. Vous recevrez un email dès que votre
                compte sera validé.</p>

            <div class="info-box">
                <i class="fas fa-info-circle"></i> Cette étape est nécessaire pour garantir la sécurité et la fiabilité
                de notre réseau médical.
            </div>

            <form action="{{ route('logout.medecin') }}" method="POST" style="margin-top: 20px;">
                @csrf
                <button type="submit" class="btn-home" style="border:none; cursor:pointer;">
                    <i class="fas fa-sign-out-alt"></i> Se déconnecter
                </button>
            </form>
        </div>
    </div>
</body>

</html>