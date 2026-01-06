<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->string('nom_allergie');
            $table->enum('type', ['medicamenteuse', 'alimentaire', 'environnementale', 'autre']);
            $table->enum('gravite', ['legere', 'moderee', 'grave', 'tres_grave']);
            $table->text('symptomes')->nullable();
            $table->text('traitement')->nullable();
            $table->date('date_decouverte')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('allergies');
    }
};