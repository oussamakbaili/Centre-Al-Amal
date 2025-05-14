<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            // Supprimer la colonne module_id si elle existe
            if (Schema::hasColumn('enseignants', 'module_id')) {
                $table->dropForeign(['module_id']);
                $table->dropColumn('module_id');
            }

            // Supprimer la colonne module si elle existe
            if (Schema::hasColumn('enseignants', 'module')) {
                $table->dropColumn('module');
            }
        });

        // Créer la table pivot si elle n'existe pas
        if (!Schema::hasTable('enseignant_module')) {
            Schema::create('enseignant_module', function (Blueprint $table) {
                $table->id();
                $table->foreignId('enseignant_id')->constrained()->onDelete('cascade');
                $table->foreignId('module_id')->constrained()->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
