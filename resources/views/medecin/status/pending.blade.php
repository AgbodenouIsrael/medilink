<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte en Attente de Validation - MediLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <div class="mb-6 text-yellow-500">
            <i class="fas fa-hourglass-half text-6xl"></i>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-4">Votre compte est en cours d'examen</h1>

        <p class="text-gray-600 mb-6">
            Merci de votre inscription, Dr. {{ Auth::guard('medecin')->user()->nom }}.<br>
            Votre dossier (y compris votre licence et certificat) est actuellement analysé par nos administrateurs.
        </p>

        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded mb-6 text-sm">
            <i class="fas fa-info-circle"></i> Vous recevrez un email dès que votre compte sera validé pour accéder à
            votre tableau de bord.
        </div>

        <form action="{{ route('logout.medecin') }}" method="POST">
            @csrf
            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded hover:bg-indigo-700 transition w-full">
                <i class="fas fa-sign-out-alt"></i> Se déconnecter
            </button>
        </form>
    </div>

</body>

</html>