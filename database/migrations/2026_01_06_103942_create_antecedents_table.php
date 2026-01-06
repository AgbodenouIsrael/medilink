<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antecedents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->enum('type', ['familial', 'personnel', 'chirurgical', 'obstetrical', 'autres']);
            $table->text('description');
            $table->date('date_diagnostic')->nullable();
            $table->enum('statut', ['actif', 'gueri', 'en_suivi'])->default('actif');
            $table->text('commentaires')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antecedents');
    }
};