// database/migrations/xxxx_create_medecins_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medecins', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('contact');
            
            // IMPORTANT: On utilise nullable() d'abord, on ajoutera la foreign key après
            $table->unsignedBigInteger('specialite_id')->nullable();
            
            $table->string('numero_licence')->unique();
            $table->string('certificat_path');
            $table->enum('statut', ['actif', 'inactif', 'en_attente'])->default('en_attente');
            $table->text('zone_couverture')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        // Ajouter la foreign key APRÈS avoir créé la table
        Schema::table('medecins', function (Blueprint $table) {
            $table->foreign('specialite_id')
                  ->references('id')
                  ->on('specialites')
                  ->onDelete('set null'); // Ou 'cascade' selon ton besoin
        });
    }

    public function down(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->dropForeign(['specialite_id']);
        });
        
        Schema::dropIfExists('medecins');
    }
};