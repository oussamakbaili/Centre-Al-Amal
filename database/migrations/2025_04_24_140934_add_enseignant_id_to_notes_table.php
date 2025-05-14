<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            // Étape 1 : ajouter la colonne d'abord sans contrainte
            $table->unsignedBigInteger('enseignant_id')->nullable()->after('id');
        });

        // Étape 2 : Affecter une valeur par défaut valide pour les lignes existantes
        if (DB::table('enseignants')->exists()) {
            $defaultEnseignantId = DB::table('enseignants')->value('id');
            DB::table('notes')->update(['enseignant_id' => $defaultEnseignantId]);
        } else {
            // Si aucun enseignant n'existe, on stoppe avec une exception explicite
            throw new Exception('Aucun enseignant trouvé pour assigner aux notes.');
        }

        // Étape 3 : ajouter la contrainte de clé étrangère
        Schema::table('notes', function (Blueprint $table) {
            $table->foreign('enseignant_id')
                ->references('id')
                ->on('enseignants')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['enseignant_id']);
            $table->dropColumn('enseignant_id');
        });
    }
};
