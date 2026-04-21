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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacie_id')->constrained('pharmacies')->onDelete('cascade');
            $table->foreignId('patient_id')->nullable()->constrained('patients')->onDelete('set null');
            $table->decimal('total_montant', 10, 2);
            $table->string('mode_paiement')->default('especes'); // especes, carte, mobile_money, assurance
            $table->timestamp('date_vente')->useCurrent();
            $table->timestamps();
        });

        Schema::create('detail_ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vente_id')->constrained('ventes')->onDelete('cascade');
            $table->foreignId('medicament_id')->constrained('medicaments')->onDelete('cascade');
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_ventes');
        Schema::dropIfExists('ventes');
    }
};
