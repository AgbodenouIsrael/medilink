<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   // database/migrations/..._create_pharmacies_table.php
public function up(): void
{
    Schema::create('pharmacies', function (Blueprint $table) {
       $table->bigIncrements('pharmacie_id');
        $table->string('nom_officine');
        $table->string('pharmacien_titulaire');
        $table->string('numero_licence')->unique();
        $table->text('adresse_complete');
        $table->string('email')->unique();
        $table->string('telephone');
        $table->string('password');
        $table->string('latitude')->nullable();
        $table->string('longitude')->nullable();
        $table->boolean('accepte_ordonnances')->default(true);
        $table->boolean('en_ligne')->default(false);
        $table->json('horaires_ouverture')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacies');
    }
};
