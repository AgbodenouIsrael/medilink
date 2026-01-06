<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. SPÉCIALITÉS (doit être la première car référencée par médecins)
        Schema::create('specialites', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 2. ZONES (doit être avant patients, hôpitaux, pharmacies)
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('ville');
            $table->timestamps();
        });

        // 3. PATIENTS
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 100);
            $table->string('prenom', 100);
            $table->date('date_naissance');
            $table->enum('genre', ['Homme', 'Femme', 'Autre']);
            $table->string('contact', 20);
            $table->string('email')->unique();
            $table->string('adresse')->nullable();
            $table->foreignId('zone_id')->nullable()->constrained('zones')->onDelete('set null');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // 4. MÉDECINS (après specialites)
        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact');
            $table->foreignId('specialite_id')->nullable()->constrained('specialites')->onDelete('set null');
            $table->string('numero_licence')->unique();
            $table->string('certificat_path');
            $table->enum('statut', ['actif', 'inactif', 'en_attente'])->default('en_attente');
            $table->text('zone_couverture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 5. HÔPITAUX (après zones)
        Schema::create('hopitals', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact');
            $table->text('adresse');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->string('fichier_enregistrement_path');
            $table->enum('statut', ['verifie', 'en_attente', 'rejete'])->default('en_attente');
            $table->rememberToken();
            $table->timestamps();
        });

        // 6. HOPITAL_MEDECINS (après hopitals ET medecins)
        Schema::create('hopital_medecins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hopital_id')->constrained('hopitals')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
            $table->string('role')->nullable();
            $table->json('horaires')->nullable();
            $table->timestamps();
            
            $table->unique(['hopital_id', 'medecin_id']);
        });

        // 7. PHARMACIES (après zones)
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('nom_officine');
            $table->string('pharmacien_titulaire');
            $table->string('numero_licence')->unique();
            $table->text('adresse_complete');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->foreignId('zone_id')->constrained('zones')->onDelete('cascade');
            $table->string('password');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->boolean('accepte_ordonnances')->default(true);
            $table->boolean('en_ligne')->default(false);
            $table->json('horaires_ouverture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        // 8. MÉDICAMENTS (après pharmacies)
        Schema::create('medicaments', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('dosage');
            $table->text('description')->nullable();
            $table->foreignId('pharmacie_id')->constrained('pharmacies')->onDelete('cascade');
            $table->integer('quantite');
            $table->integer('seuil_alerte')->default(10);
            $table->decimal('prix_unitaire', 10, 2);
            $table->date('date_expiration')->nullable();
            $table->boolean('visible_public')->default(true);
            $table->timestamps();
        });

        // 9. ADMINS (indépendant)
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['superadmin', 'admin', 'moderateur'])->default('admin');
            $table->rememberToken();
            $table->timestamps();
        });

        // 10. DOSSIERS MÉDICAUX (après patients ET médecins)
        Schema::create('dossier_medicaux', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->nullable()->constrained('medecins')->onDelete('set null');
            $table->text('antecedents')->nullable();
            $table->text('allergies')->nullable();
            $table->text('traitements_en_cours')->nullable();
            $table->json('documents')->nullable();
            $table->enum('acces', ['public', 'prive', 'partage'])->default('prive');
            $table->timestamps();
        });

        // 11. RENDEZ-VOUS (après patients, médecins, hôpitaux)
        Schema::create('rendez_vous', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
            $table->foreignId('hopital_id')->nullable()->constrained('hopitals')->onDelete('set null');
            $table->dateTime('date_heure');
            $table->enum('statut', ['planifie', 'confirme', 'annule', 'termine'])->default('planifie');
            $table->text('motif')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // 12. CHATS
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // patient-medecin, patient-pharmacie, etc.
            $table->string('statut')->default('actif');
            $table->timestamps();
        });

        // 13. MESSAGES (après chats)
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');
            $table->string('expediteur_type'); // Patient, Medecin, etc.
            $table->unsignedBigInteger('expediteur_id');
            $table->text('contenu');
            $table->boolean('lu')->default(false);
            $table->timestamp('date_envoi')->useCurrent();
            $table->timestamps();
        });

        // 14. VALIDATIONS (après admins)
        Schema::create('validations', function (Blueprint $table) {
            $table->id();
            $table->string('validable_type'); // Medecin, Hopital, Pharmacie
            $table->unsignedBigInteger('validable_id');
            $table->foreignId('admin_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->enum('statut', ['en_attente', 'approuve', 'rejete'])->default('en_attente');
            $table->text('commentaire')->nullable();
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();
        });

        // 15. CONSULTATION HISTORIQUES (après patients, médecins)
        Schema::create('consultation_historiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->constrained('medecins')->onDelete('cascade');
            $table->date('date_consultation');
            $table->text('diagnostic');
            $table->text('ordonnance')->nullable();
            $table->json('examens')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Supprimer dans l'ordre INVERSE
        Schema::dropIfExists('consultation_historiques');
        Schema::dropIfExists('validations');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('rendez_vous');
        Schema::dropIfExists('dossier_medicaux');
        Schema::dropIfExists('medicaments');
        Schema::dropIfExists('pharmacies');
        Schema::dropIfExists('hopital_medecins');
        Schema::dropIfExists('hopitals');
        Schema::dropIfExists('medecins');
        Schema::dropIfExists('patients');
        Schema::dropIfExists('zones');
        Schema::dropIfExists('specialites');
        Schema::dropIfExists('admins');
    }
};