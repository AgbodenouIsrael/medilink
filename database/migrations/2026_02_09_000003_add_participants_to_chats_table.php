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
        Schema::table('chats', function (Blueprint $table) {
            $table->foreignId('pharmacie_id')->nullable()->constrained('pharmacies')->onDelete('cascade');
            $table->foreignId('hopital_id')->nullable()->constrained('hopitals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            $table->dropForeign(['pharmacie_id']);
            $table->dropForeign(['hopital_id']);
            $table->dropColumn(['pharmacie_id', 'hopital_id']);
        });
    }
};
