<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Dans la migration patients (2024_..._create_patients_table.php)
public function up(): void
{
    Schema::create('patients', function (Blueprint $table) {
        $table->bigIncrements('patient_id');
        $table->string('nom', 100);
        $table->string('prenom', 100);
        $table->date('date_naissance');
        $table->enum('genre', ['Homme', 'Femme', 'Autre']);
        $table->string('contact', 20);
        $table->string('email')->unique();
        $table->string('adresse')->nullable();
        $table->string('zone')->nullable();
        $table->string('password');
        $table->rememberToken();
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

