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
        Schema::create('ordonnance_medicaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordonnance_id')->constrained('ordonnances')->onDelete('cascade');
            $table->string('nom_medicament');
            $table->string('dosage')->nullable();
            $table->text('instructions')->nullable();
            $table->integer('quantite')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordonnance_medicaments');
    }
};
