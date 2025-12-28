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
            $table->id('patient_id'); 

            $table->string('nom', 100);
            
            $table->string('prenom', 100);
            
            $table->date('date_naissance');
            
            $table->enum('genre', ['Homme', 'Femme', 'Autre']);
            
            $table->string('contact', 20); 
            
            $table->string('email')->unique(); 
            
            $table->string('adresse');
            
            $table->string('zone');
            
            $table->string('mot_de_passe');
            
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
