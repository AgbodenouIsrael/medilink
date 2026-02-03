<x-mail::message>
    # Félicitations ! Votre compte est validé.

    Bonjour {{ $entity->nom }},

    Nous avons le plaisir de vous informer que votre inscription sur la plateforme Medilink a été auditée et validée
    par nos administrateurs.

    Vous pouvez désormais vous connecter et accéder à votre espace professionnel.

    <x-mail::button :url="route('connexion')">
        Se Connecter
    </x-mail::button>

    Cordialement,
    L'équipe {{ config('app.name') }}
</x-mail::message>