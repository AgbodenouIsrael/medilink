<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordonnances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('medecin_id')->nullable()->constrained('medecins')->onDelete('set null');
            $table->date('date_prescription');
            $table->string('numero_ordonnance')->unique();
            $table->enum('statut', ['active', 'terminee', 'annulee'])->default('active');
            $table->text('instructions')->nullable();
            $table->date('date_debut_traitement')->nullable();
            $table->date('date_fin_traitement')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordonnances');
    }
};