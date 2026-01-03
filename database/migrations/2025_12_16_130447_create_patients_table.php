<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('patients', function (Blueprint $table) {
        $table->id('patient_id'); // OK, mais n'oublie pas de définir $primaryKey = 'patient_id' dans ton modèle
        $table->string('nom', 100);
        $table->string('prenom', 100);
        $table->date('date_naissance');
        $table->enum('genre', ['Homme', 'Femme', 'Autre']);
        $table->string('contact', 20);
        $table->string('email')->unique();
        $table->string('adresse')->nullable(); // J'ai ajouté nullable, car l'adresse n'est pas toujours critique au début
        $table->string('zone')->nullable();
        
        // CORRECTION MAJEURE ICI : On utilise 'password'
        $table->string('password'); 
        
        $table->rememberToken(); // Indispensable pour "Se souvenir de moi"
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};