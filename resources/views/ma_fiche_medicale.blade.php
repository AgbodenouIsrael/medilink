<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Dossier Médical - Medilink</title>
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Styles Sections */
        .medical-record-sections { display: flex; flex-direction: column; gap: 30px; }
        .medical-section { 
            background-color: #fff; padding: 25px 30px; border-radius: 10px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); border-left: 5px solid #3498db; 
        }
        .medical-info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .info-item label { font-weight: bold; color: #555; display: block; margin-bottom: 5px; }
        .info-item p { background-color: #f9f9f9; border: 1px solid #eee; padding: 10px; border-radius: 5px; min-height: 40px; }
        
        /* Tables et Listes */
        .table-container { overflow-x: auto; margin-top: 20px; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #f8f9fa; padding: 12px; text-align: left; border-bottom: 2px solid #dee2e6; }
        .data-table td { padding: 12px; border-bottom: 1px solid #dee2e6; }
        .data-table tr:hover { background: #f8f9fa; }
        
        /* Badges */
        .badge { padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-familial { background: #e3f2fd; color: #1976d2; }
        .badge-personnel { background: #f3e5f5; color: #7b1fa2; }
        .badge-chirurgical { background: #fff3e0; color: #f57c00; }
        .badge-ordonnance { background: #e8f5e9; color: #2e7d32; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        .badge-dark { background: #d6d8d9; color: #1b1e21; }
        
        /* Boutons Actions */
        .btn-action { padding: 5px 10px; margin: 0 3px; border-radius: 4px; border: none; cursor: pointer; }
        .btn-edit { background: #3498db; color: white; }
        .btn-delete { background: #e74c3c; color: white; }
        .btn-add { background: #2ecc71; color: white; padding: 8px 15px; border-radius: 5px; border: none; cursor: pointer; }
        
        /* Modal Style */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); }
        .modal-content { background: #fff; margin: 5% auto; padding: 20px; border-radius: 10px; width: 50%; max-width: 600px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); }
        .modal-header { border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .full-width { grid-column: span 2; }
        .modal-footer { text-align: right; padding-top: 15px; border-top: 1px solid #eee; }
        .btn-save { background: #3498db; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        .btn-cancel { background: #ccc; padding: 10px 20px; border-radius: 5px; cursor: pointer; border: none; margin-right: 10px; }
        
        /* Documents */
        .document-list { display: flex; flex-direction: column; gap: 10px; }
        .document-item { display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #f8f9fa; border-radius: 5px; }
        .document-info { display: flex; align-items: center; gap: 10px; }
        .document-icon { font-size: 24px; color: #666; }
        
        /* Messages d'alerte */
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        
        .no-data { color: #777; font-style: italic; padding: 20px; text-align: center; }
    </style>
</head>
<body class="dashboard-body patient-theme">
    @php
        // CORRECTION : Initialiser TOUTES les variables
        use Illuminate\Support\Facades\Auth;
        
        // Récupérer le patient connecté
        $patient = Auth::guard('patient')->user();
        
        // Vérifier si le patient est connecté
        if (!$patient) {
            // Rediriger vers la connexion si non connecté
            header('Location: ' . route('connexion'));
            exit;
        }
        
        // Initialiser les collections pour éviter les erreurs
        $antecedents = isset($antecedents) ? $antecedents : collect();
        $allergies = isset($allergies) ? $allergies : collect();
        $ordonnances = isset($ordonnances) ? $ordonnances : collect();
        $diagnostiques = isset($diagnostiques) ? $diagnostiques : collect();
        $traitements = isset($traitements) ? $traitements : collect();
        $documents = isset($documents) ? $documents : collect();
        
        // Fonction helper pour formater les dates
        if (!function_exists('formatDate')) {
            function formatDate($date) {
                if (!$date) return '-';
                try {
                    return \Carbon\Carbon::parse($date)->format('d/m/Y');
                } catch (\Exception $e) {
                    return '-';
                }
            }
        }
    @endphp

    <div class="sidebar">
        <h1 class="logo"><i class="fas fa-heartbeat"></i> MediLink</h1>
        <nav class="nav-menu">
            <a href="{{ route('dashboard_patient') }}" class="nav-item"><i class="fas fa-columns"></i> Tableau de Bord</a>
            <a href="#" class="nav-item active"><i class="fas fa-file-medical"></i> Dossier Médical</a>
            <a href="{{ route('connexion') }}" class="nav-item logout"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </nav>
    </div>

    <div class="main-content">
        <header class="dashboard-header">
            <h2>Mon Dossier Médical</h2>
            <p>Bienvenue, {{ $patient->prenom }}, gérez vos informations de santé en temps réel.</p>
        </header>

        <!-- Messages de succès/erreur -->
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        <section class="medical-record-sections">
            <!-- Section Informations Personnelles -->
            <div class="medical-section">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3><i class="fas fa-user-circle"></i> Informations Personnelles</h3>
                    <a href="{{ route('profil') }}"><button id="openModal" class="btn-add"><i class="fas fa-edit"></i> Modifier le profil</button></a>
                </div>
                <div class="medical-info-grid">
                    <div class="info-item"><label>Nom Complet</label><p>{{ $patient->prenom }} {{ $patient->nom }}</p></div>
                    <div class="info-item"><label>Date de Naissance</label><p>{{ formatDate($patient->date_naissance) }}</p></div>
                    <div class="info-item"><label>Genre</label><p>{{ $patient->genre ?? 'Non renseigné' }}</p></div>
                    <div class="info-item"><label>Contact</label><p>{{ $patient->contact ?? 'Non renseigné' }}</p></div>
                    <div class="info-item"><label>Email</label><p>{{ $patient->email }}</p></div>
                    <div class="info-item"><label>Adresse</label><p>{{ $patient->adresse ?? 'Non renseigné' }}</p></div>
                </div>
            </div>

            <!-- Section Antécédents Médicaux -->
            <div class="medical-section">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3><i class="fas fa-history"></i> Antécédents Médicaux</h3>
                    <button onclick="openModal('antecedent')" class="btn-add"><i class="fas fa-plus"></i> Ajouter un antécédent</button>
                </div>
                
                @if($antecedents->isEmpty())
                    <p class="no-data">Aucun antécédent médical enregistré.</p>
                @else
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Description</th>
                                    <th>Date diagnostic</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($antecedents as $antecedent)
                                <tr>
                                    <td>
                                        @php
                                            $typeClasses = [
                                                'familial' => 'badge-familial',
                                                'personnel' => 'badge-personnel', 
                                                'chirurgical' => 'badge-chirurgical',
                                                'obstetrical' => 'badge-warning',
                                                'autres' => 'badge-dark'
                                            ];
                                            $badgeClass = $typeClasses[$antecedent->type] ?? 'badge-dark';
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
                                            {{ ucfirst($antecedent->type) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($antecedent->description, 100) }}</td>
                                    <td>{{ formatDate($antecedent->date_diagnostic) }}</td>
                                    <td>{{ ucfirst($antecedent->statut) }}</td>
                                    <td>
                                        <button onclick="editAntecedent({{ $antecedent->id }})" class="btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('antecedent.destroy', $antecedent->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Supprimer cet antécédent ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Section Allergies -->
            <div class="medical-section">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3><i class="fas fa-allergies"></i> Allergies</h3>
                    <button onclick="openModal('allergie')" class="btn-add"><i class="fas fa-plus"></i> Ajouter une allergie</button>
                </div>
                
                @if($allergies->isEmpty())
                    <p class="no-data">Aucune allergie déclarée.</p>
                @else
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nom de l'allergie</th>
                                    <th>Type</th>
                                    <th>Gravité</th>
                                    <th>Date découverte</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allergies as $allergie)
                                <tr>
                                    <td><strong>{{ $allergie->nom_allergie }}</strong></td>
                                    <td>{{ ucfirst($allergie->type) }}</td>
                                    <td>
                                        @php
                                            $graviteColors = [
                                                'legere' => 'badge-success',
                                                'moderee' => 'badge-warning',
                                                'grave' => 'badge-danger',
                                                'tres_grave' => 'badge-dark'
                                            ];
                                        @endphp
                                        <span class="badge {{ $graviteColors[$allergie->gravite] ?? 'badge-dark' }}">
                                            {{ ucfirst($allergie->gravite) }}
                                        </span>
                                    </td>
                                    <td>{{ formatDate($allergie->date_decouverte) }}</td>
                                    <td>
                                        <form action="{{ route('allergie.destroy', $allergie->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Supprimer cette allergie ?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Section Ordonnances -->
            <div class="medical-section">
                <h3><i class="fas fa-prescription"></i> Ordonnances Récentes</h3>
                
                @if($ordonnances->isEmpty())
                    <p class="no-data">Aucune ordonnance récente.</p>
                @else
                    <div class="table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>N° Ordonnance</th>
                                    <th>Date</th>
                                    <th>Médecin</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordonnances as $ordonnance)
                                <tr>
                                    <td><strong>{{ $ordonnance->numero_ordonnance ?? 'N/A' }}</strong></td>
                                    <td>{{ formatDate($ordonnance->date_prescription) }}</td>
                                    <td>{{ $ordonnance->medecin->nom ?? 'Non spécifié' }}</td>
                                    <td>
                                        <span class="badge badge-ordonnance">
                                            {{ ucfirst($ordonnance->statut) }}
                                        </span>
                                    </td>
                                    <td>
                                        <button class="btn-action btn-edit">
                                            <i class="fas fa-eye"></i> Voir
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Section Documents Médicaux -->
            <div class="medical-section">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3><i class="fas fa-file-medical-alt"></i> Documents Médicaux</h3>
                    <button onclick="openModal('document')" class="btn-add"><i class="fas fa-upload"></i> Importer un document</button>
                </div>
                
                @if($documents->isEmpty())
                    <p class="no-data">Aucun document importé.</p>
                @else
                    <div class="document-list">
                        @foreach($documents as $document)
                        <div class="document-item">
                            <div class="document-info">
                                <i class="fas fa-file-pdf document-icon"></i>
                                <div>
                                    <strong>{{ $document->titre }}</strong><br>
                                    <small>Type: {{ ucfirst($document->type_document) }} • 
                                        Date: {{ formatDate($document->date_document) }}</small>
                                </div>
                            </div>
                            <div>
                                <a href="{{ Storage::url($document->chemin_fichier) }}" target="_blank" class="btn-action btn-edit">
                                    <i class="fas fa-download"></i> Télécharger
                                </a>
                                <form action="{{ route('document.destroy', $document->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" onclick="return confirm('Supprimer ce document ?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>
    </div>


        <!-- Modal pour Antécédents -->
    <div id="modalAntecedent" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-history"></i> Ajouter un Antécédent</h3>
                <span onclick="closeModal('modalAntecedent')" style="cursor: pointer; font-size: 24px;">&times;</span>
            </div>
            <form action="{{ route('antecedent.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="type">Type d'antécédent *</label>
                        <select name="type" id="type" required>
                            <option value="familial">Familial</option>
                            <option value="personnel">Personnel</option>
                            <option value="chirurgical">Chirurgical</option>
                            <option value="obstetrical">Obstétrical</option>
                            <option value="autres">Autres</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_diagnostic">Date diagnostic *</label>
                        <input type="date" name="date_diagnostic" id="date_diagnostic" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description *</label>
                        <textarea name="description" id="description" rows="3" required placeholder="Décrivez l'antécédent..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="statut">Statut *</label>
                        <select name="statut" id="statut" required>
                            <option value="actif">Actif</option>
                            <option value="gueri">Guéri</option>
                            <option value="chronique">Chronique</option>
                            <option value="en_suivi">En suivi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="commentaires">Commentaires</label>
                        <textarea name="commentaires" id="commentaires" rows="2" placeholder="Commentaires supplémentaires..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modalAntecedent')" class="btn-cancel">Annuler</button>
                    <button type="submit" class="btn-save"><i class="fas fa-save"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour Allergies -->
    <div id="modalAllergie" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-allergies"></i> Ajouter une Allergie</h3>
                <span onclick="closeModal('modalAllergie')" style="cursor: pointer; font-size: 24px;">&times;</span>
            </div>
            <form action="{{ route('allergie.store') }}" method="POST">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nom_allergie">Nom de l'allergie *</label>
                        <input type="text" name="nom_allergie" id="nom_allergie" required placeholder="Ex: Pénicilline, Arachides...">
                    </div>
                    <div class="form-group">
                        <label for="type">Type *</label>
                        <select name="type" id="type" required>
                            <option value="medicamenteuse">Médicamenteuse</option>
                            <option value="alimentaire">Alimentaire</option>
                            <option value="respiratoire">Respiratoire</option>
                            <option value="cutanee">Cutannée</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="gravite">Gravité *</label>
                        <select name="gravite" id="gravite" required>
                            <option value="legere">Légère</option>
                            <option value="moderee">Modérée</option>
                            <option value="grave">Grave</option>
                            <option value="tres_grave">Très grave</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_decouverte">Date de découverte *</label>
                        <input type="date" name="date_decouverte" id="date_decouverte" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="symptomes">Symptômes observés</label>
                        <textarea name="symptomes" id="symptomes" rows="2" placeholder="Décrivez les symptômes..."></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="traitement_urgence">Traitement d'urgence</label>
                        <textarea name="traitement_urgence" id="traitement_urgence" rows="2" placeholder="Que faire en cas de réaction..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modalAllergie')" class="btn-cancel">Annuler</button>
                    <button type="submit" class="btn-save"><i class="fas fa-save"></i> Enregistrer</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal pour Documents -->
    <div id="modalDocument" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-file-upload"></i> Importer un Document</h3>
                <span onclick="closeModal('modalDocument')" style="cursor: pointer; font-size: 24px;">&times;</span>
            </div>
            <form action="{{ route('document.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titre">Titre du document *</label>
                        <input type="text" name="titre" id="titre" required placeholder="Ex: Radiographie thoracique">
                    </div>
                    <div class="form-group">
                        <label for="type_document">Type de document *</label>
                        <select name="type_document" id="type_document" required>
                            <option value="ordonnance">Ordonnance</option>
                            <option value="radiographie">Radiographie</option>
                            <option value="analyse">Analyse médicale</option>
                            <option value="compte_rendu">Compte-rendu</option>
                            <option value="certificat">Certificat médical</option>
                            <option value="autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_document">Date du document</label>
                        <input type="date" name="date_document" id="date_document">
                    </div>
                    <div class="form-group full-width">
                        <label for="fichier">Fichier *</label>
                        <input type="file" name="fichier" id="fichier" required accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <small>Formats acceptés: PDF, JPG, PNG, DOC (max: 5MB)</small>
                    </div>
                    <div class="form-group full-width">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Description du document..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="closeModal('modalDocument')" class="btn-cancel">Annuler</button>
                    <button type="submit" class="btn-save"><i class="fas fa-upload"></i> Importer</button>
                </div>
            </form>
        </div>
    </div>

    <script>

        // Fonctions pour gérer les modals
        function openModal(type) {
            document.getElementById('modal' + type.charAt(0).toUpperCase() + type.slice(1)).style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        function editAntecedent(id) {
            // Ici vous ajouteriez la logique pour pré-remplir le formulaire d'édition
            // Pour l'instant, on ouvre le modal d'ajout
            openModal('antecedent');
            // Vous devrez ajouter une requête AJAX pour récupérer les données
        }
        
        // Modal pour le profil
        const editModal = document.getElementById("editModal");
        const openProfileBtn = document.getElementById("openModal");
        const closeProfileBtn = document.getElementById("closeModal");
        
        if (openProfileBtn) {
            openProfileBtn.onclick = () => editModal.style.display = "block";
        }
        
        if (closeProfileBtn) {
            closeProfileBtn.onclick = () => editModal.style.display = "none";
        }
        
        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
    

        // Fonctions pour gérer les modals
        function openModal(type) {
            const modalId = 'modal' + type.charAt(0).toUpperCase() + type.slice(1);
            document.getElementById(modalId).style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Fermer les modals en cliquant à l'extérieur
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }
        
        // Fermer avec la touche Echap
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                const modals = document.getElementsByClassName('modal');
                for (let modal of modals) {
                    modal.style.display = 'none';
                }
            }
        };
    </script>
</body>
</html>