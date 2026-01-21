<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Autorisations - MediLink</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="text-2xl font-bold text-blue-600">MediLink</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <a href="{{ route('dashboard_patient') }}"
                        class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Retour au
                        Dashboard</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Messages Alert -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des Accès Médicaux</h1>

        <!-- Demandes en attente -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-8">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-yellow-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <i class="fas fa-clock text-yellow-500 mr-2"></i>Demandes en attente
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Mèdecins demandant l'accès à votre dossier.</p>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($autorisations->where('statut', 'en_attente') as $auth)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-blue-600 truncate">
                                    Dr. {{ $auth->medecin->prenom }} {{ $auth->medecin->nom }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Motif: {{ $auth->motif }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    Type d'accès: <strong>{{ ucfirst($auth->type_acces) }}</strong>
                                </span>
                            </div>
                            <div class="flex space-x-2">
                                <form action="{{ route('autorisations.update', $auth->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="statut" value="approuve">
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none">
                                        <i class="fas fa-check mr-1"></i> Accepter
                                    </button>
                                </form>
                                <form action="{{ route('autorisations.update', $auth->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="statut" value="refuse">
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-full shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                                        <i class="fas fa-times mr-1"></i> Refuser
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-6 text-center text-gray-500 italic">Aucune demande en attente.</li>
                @endforelse
            </ul>
        </div>

        <!-- Accès Actifs -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200 bg-green-50">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    <i class="fas fa-user-md text-green-500 mr-2"></i>Médecins Autorisés
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Liste des professionnels ayant accès à votre dossier.
                </p>
            </div>
            <ul class="divide-y divide-gray-200">
                @forelse($autorisations->where('statut', 'approuve') as $auth)
                    <li class="px-4 py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-900">
                                    Dr. {{ $auth->medecin->prenom }} {{ $auth->medecin->nom }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    Spécialité: {{ $auth->medecin->specialite->nom ?? 'Généraliste' }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    Expire le: {{ $auth->date_fin ? $auth->date_fin->format('d/m/Y') : 'Illimité' }}
                                </span>
                            </div>
                            <div>
                                <form action="{{ route('autorisations.destroy', $auth->id) }}" method="POST"
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir révoquer l\'accès ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                        <i class="fas fa-ban mr-1 text-red-500"></i> Révoquer
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-6 text-center text-gray-500 italic">Aucun médecin n'a accès à votre dossier
                        actuellement.</li>
                @endforelse
            </ul>
        </div>
    </div>
</body>

</html>