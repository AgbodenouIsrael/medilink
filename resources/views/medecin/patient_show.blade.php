@extends('layouts.app')

<!-- Assuming a layout exists, or I will create a standalone structure similar to other files -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossier Patient - {{ $patient->prenom }} {{ $patient->nom }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

    <div class="container mx-auto px-4 py-8">
        <a href="{{ route('mes_patients') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <i class="fas fa-arrow-left"></i> Retour à mes patients
        </a>

        <!-- Header Patient -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $patient->prenom }} {{ $patient->nom }}</h1>
                    <p class="text-gray-600">Né(e) le {{ $patient->date_naissance->format('d/m/Y') }}
                        ({{ $patient->date_naissance->age }} ans) - {{ $patient->genre }}</p>
                    <p class="text-gray-600"><i class="fas fa-phone"></i> {{ $patient->contact }} | <i
                            class="fas fa-envelope"></i> {{ $patient->email }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                        Dossier Actif
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Colonne Gauche : Infos Médicales -->
            <div class="space-y-6">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4 text-indigo-700">Antécédents</h3>
                    @if($patient->antecedents->isEmpty())
                        <p class="text-gray-500 italic">Aucun antécédent noté.</p>
                    @else
                        <ul class="list-disc pl-5">
                            @foreach($patient->antecedents as $ant)
                                <li class="mb-1">
                                    <span class="font-medium">{{ $ant->type }}</span>: {{ $ant->description }}
                                    <br><span
                                        class="text-xs text-gray-400">{{ $ant->date_debut ? 'Depuis ' . $ant->date_debut : '' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4 text-red-600">Allergies</h3>
                    @if($patient->allergies->isEmpty())
                        <p class="text-gray-500 italic">Aucune allergie connue.</p>
                    @else
                        <ul class="list-disc pl-5 text-red-600">
                            @foreach($patient->allergies as $alg)
                                <li class="mb-1">
                                    <span class="font-bold">{{ $alg->allergene }}</span>: {{ $alg->reaction }}
                                    <br><span class="text-xs text-gray-400">{{ $alg->severite }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <!-- Colonne Droite : Consultations & Mises à jour -->
            <div class="md:col-span-2 space-y-6">

                <!-- Nouvelle Consultation Form -->
                <div class="bg-white shadow rounded-lg p-6 border-l-4 border-indigo-500">
                    <h3 class="text-xl font-bold mb-4">Nouvelle Consultation</h3>
                    <form action="{{ route('medecin.consultation.store', $patient->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Diagnostic / Observations</label>
                            <textarea name="diagnostic" rows="3" required
                                class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                placeholder="Observations cliniques..."></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-bold mb-2">Ordonnance / Traitement</label>
                            <textarea name="ordonnance" rows="3"
                                class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                placeholder="Médicaments, posologie..."></textarea>
                        </div>
                        <button type="submit"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                            <i class="fas fa-save"></i> Enregistrer Consultation
                        </button>
                    </form>
                </div>

                <!-- Historique -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold mb-4">Historique des Consultations</h3>
                    @if($historique->isEmpty())
                        <p class="text-gray-500 text-center py-4">Aucune consultation enregistrée.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($historique as $consult)
                                <div class="border-b pb-4 last:border-b-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h4 class="font-bold text-lg text-gray-800">
                                                {{ $consult->date_consultation->format('d/m/Y') }}
                                            </h4>
                                            <span class="text-sm text-gray-500">Dr. {{ $consult->medecin->nom }}
                                                {{ $consult->medecin->prenom }}</span>
                                        </div>
                                        <button class="text-gray-400 hover:text-indigo-600"><i
                                                class="fas fa-print"></i></button>
                                    </div>
                                    <div class="bg-gray-50 p-3 rounded mb-2">
                                        <p class="font-semibold text-gray-700">Diagnostic:</p>
                                        <p class="text-gray-600">{{ $consult->diagnostic }}</p>
                                    </div>
                                    @if($consult->ordonnance)
                                        <div class="bg-blue-50 p-3 rounded border border-blue-100">
                                            <p class="font-semibold text-blue-800"><i class="fas fa-prescription"></i> Ordonnance:
                                            </p>
                                            <p class="text-blue-700 whitespace-pre-wrap">{{ $consult->ordonnance }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</body>

</html>