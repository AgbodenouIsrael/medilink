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
        Schema::table('autorisations', function (Blueprint $table) {
            $table->timestamp('date_debut')->nullable()->after('statut');
            // created_by can be polymorphic or just an ID if we know the guard context
            // But since we have multiple user types (Medecin, Hopital), we might need created_by_id and created_by_type
            // OR just store the user ID if we trust the context. 
            // Let's use polymorphic to be safe and track exactly who asked.
            $table->nullableMorphs('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('autorisations', function (Blueprint $table) {
            $table->dropColumn('date_debut');
            $table->dropMorphs('created_by');
        });
    }
};
