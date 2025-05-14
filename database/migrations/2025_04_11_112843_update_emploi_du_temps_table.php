<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('emploi_du_temps', function (Blueprint $table) {
        // Supprimer d'abord les colonnes existantes si nécessaire
        if (Schema::hasColumn('emploi_du_temps', 'matiere')) {
            $table->dropColumn('matiere');
        }
        
        if (Schema::hasColumn('emploi_du_temps', 'etudiant_id')) {
            $table->dropForeign(['etudiant_id']);
            $table->dropColumn('etudiant_id');
        }
        
        // Vérifier si la colonne module_id n'existe pas déjà avant de l'ajouter
        if (!Schema::hasColumn('emploi_du_temps', 'module_id')) {
            $table->foreignId('module_id')->constrained();
        } else {
            // Si elle existe déjà, juste ajouter la contrainte de clé étrangère si elle n'existe pas
            $table->foreign('module_id')->references('id')->on('modules');
        }
    });
}

public function down()
{
    Schema::table('emploi_du_temps', function (Blueprint $table) {
        $table->dropForeign(['module_id']);
        $table->string('matiere')->nullable();
        $table->foreignId('etudiant_id')->constrained();
    });
}
};
