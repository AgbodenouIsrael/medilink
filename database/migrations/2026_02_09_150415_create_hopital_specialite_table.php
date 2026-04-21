<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hopital_specialite', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hopital_id')->constrained('hopitals')->onDelete('cascade');
            $table->foreignId('specialite_id')->constrained('specialites')->onDelete('cascade');
            $table->text('description')->nullable(); // Optional description (e.g., "24/7 emergency", "Maternity ward with 20 beds")
            $table->timestamps();

            // Ensure a hospital can't have the same specialty twice
            $table->unique(['hopital_id', 'specialite_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hopital_specialite');
    }
};
