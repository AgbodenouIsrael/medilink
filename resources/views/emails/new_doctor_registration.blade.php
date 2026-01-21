<x-mail::message>
    # Nouvelle Inscription Médecin

    Un nouveau médecin vient de s'inscrire sur la plateforme et attend votre validation.

    **Détails du Médecin :**
    * **Nom :** Dr. {{ $medecin->prenom }} {{ $medecin->nom }}
    * **Email :** {{ $medecin->email }}
    * **Spécialité :** {{ $medecin->specialite->nom ?? 'Non définie' }}
    * **Numéro Licence :** {{ $medecin->numero_licence }}

    Veuillez vous connecter à l'espace administration pour vérifier ses documents et valider son compte.

    <x-mail::button :url="route('admin.validations')">
        Accéder aux Validations
    </x-mail::button>

    Merci,<br>
    {{ config('app.name') }}
</x-mail::message>