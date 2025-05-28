<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Supprimer la contrainte de clé étrangère
            $table->dropForeign(['etudiant_id']);

            // Supprimer ensuite la colonne
            $table->dropColumn('etudiant_id');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->unsignedBigInteger('etudiant_id')->nullable();

            // Restaurer la contrainte si besoin
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
        });
    }
};
