@extends('layouts.patient')

@section('title', 'Mon Profil & Paramètres - Medilink')

@section('styles')
    <style>
        /* Styles spécifiques pour la page Profil/Paramètres */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            /* Deux colonnes pour la structure principale */
            gap: 30px;
        }

        .settings-card {
            background-color: white;
            /* was var(--color-card-background) */
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .settings-card h3 {
            color: #3498db;
            /* var(--color-patient) */
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
            /* var(--color-border) */
            font-size: 1.4em;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .action-list {
            list-style: none;
            padding: 0;
        }

        .action-list li {
            margin-bottom: 15px;
        }

        .action-list a,
        .action-list button {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-decoration: none;
            color: #333;
            /* var(--color-text) */
            transition: background-color 0.2s, border-color 0.2s;
            cursor: pointer;
            background-color: white;
            text-align: left;
            font-weight: 500;
        }

        .action-list a:hover,
        .action-list button:hover {
            background-color: #f5f5f5;
            border-color: #3498db;
            /* var(--color-patient) */
        }

        .action-list i {
            margin-right: 15px;
            color: #3498db;
            /* var(--color-patient) */
            min-width: 20px;
        }

        /* Section d'Urgence */
        .emergency-card {
            grid-column: 1 / -1;
            /* Prend toute la largeur */
            background-color: #ffebee;
            /* Rouge très clair (Urgence) */
            color: #D32F2F;
            /* Rouge foncé */
            border: 2px solid #D32F2F;
            text-align: center;
            padding: 20px;
        }

        .emergency-card h4 {
            font-size: 1.6em;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .emergency-card .emergency-number {
            font-size: 2.5em;
            font-weight: bold;
            color: #D32F2F;
            text-decoration: none;
            display: block;
        }
    </style>
@endsection

@section('content')
    <header class="dashboard-header">
        <h2>Mon Profil & Paramètres</h2>
        <p>Gérez votre compte, obtenez de l'aide et accédez aux ressources de Medilink.</p>
    </header>

    <section class="profile-grid">

        <div class="settings-card">
            <h3><i class="fas fa-user-cog"></i> Gestion du Compte</h3>
            <ul class="action-list">
                <li>
                    <a href="modifier_infos.html">
                        <i class="fas fa-edit"></i> Modifier mes Informations Personnelles
                    </a>
                </li>
                <li>
                    <a href="modifier_mdp.html">
                        <i class="fas fa-key"></i> Changer mon Mot de Passe
                    </a>
                </li>
                <li>
                    <button type="button">
                        <i class="fas fa-bell"></i> Gérer les Notifications (Activer/Désactiver)
                    </button>
                </li>
                <li>
                    <a href="desactiver_compte.html" style="color: #D32F2F;">
                        <i class="fas fa-trash-alt"></i> Désactiver mon Compte
                    </a>
                </li>
            </ul>

            <h3 style="margin-top: 30px;"><i class="fas fa-headset"></i> Centre d'Aide</h3>
            <ul class="action-list">
                <li>
                    <a href="faq.html">
                        <i class="fas fa-question-circle"></i> Questions Fréquemment Posées (FAQ)
                    </a>
                </li>
                <li>
                    <button type="button" disabled style="opacity: 0.5;">
                        <i class="fas fa-robot"></i> Chat IA (Future Version)
                    </button>
                </li>
                <li>
                    <a href="mailto:admin@medilink.com">
                        <i class="fas fa-envelope"></i> Contacter l'Administrateur (Email)
                    </a>
                </li>
                <li>
                    <a href="tel:+33123456789">
                        <i class="fas fa-phone"></i> Contacter l'Administrateur (Téléphone)
                    </a>
                </li>
            </ul>
        </div>

        <div class="settings-card">
            <h3><i class="fas fa-book-open"></i> Ressources & Infos Légales</h3>
            <ul class="action-list">
                <li>
                    <a href="guide_utilisation.html" target="_blank">
                        <i class="fas fa-file-alt"></i> Guide d'utilisation
                    </a>
                </li>
                <li>
                    <a href="cgu.html" target="_blank">
                        <i class="fas fa-gavel"></i> Conditions d'utilisation
                    </a>
                </li>
                <li>
                    <a href="confidentialite.html" target="_blank">
                        <i class="fas fa-user-shield"></i> Politique de confidentialité
                    </a>
                </li>
                <li>
                    <a href="apropos.html" target="_blank">
                        <i class="fas fa-info-circle"></i> À propos de MediLink
                    </a>
                </li>
            </ul>

            <h3 style="margin-top: 30px;"><i class="fas fa-info-circle"></i> Questions Fréquentes (Exemples)</h3>
            <ul class="action-list">
                <li>
                    <a href="faq.html#creer-fiche">
                        <i class="fas fa-chevron-right"></i> Comment créer ma fiche médicale ?
                    </a>
                </li>
                <li>
                    <a href="faq.html#trouver-pharmacie">
                        <i class="fas fa-chevron-right"></i> Comment trouver une pharmacie de garde ?
                    </a>
                </li>
                <li>
                    <a href="faq.html#rdv-medecin">
                        <i class="fas fa-chevron-right"></i> Comment prendre RDV avec un médecin ?
                    </a>
                </li>
            </ul>
        </div>

        <div class="emergency-card">
            <h4><i class="fas fa-exclamation-triangle"></i> Urgence Médicale</h4>
            <p>Composez ce numéro **seulement** en cas d'urgence vitale.</p>
            <a href="tel:117" class="emergency-number">117</a>
        </div>

    </section>
@endsection