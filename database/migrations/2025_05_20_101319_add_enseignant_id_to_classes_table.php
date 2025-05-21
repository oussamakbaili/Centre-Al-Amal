<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnseignantIdToClassesTable extends Migration
{
    public function up()
    {
        Schema::table('classes', function (Blueprint $table) {
            // Ajouter la colonne enseignant_id
            $table->unsignedBigInteger('enseignant_id')->after('id');

            // Ajouter la clé étrangère
            $table->foreign('enseignant_id')
                  ->references('id')
                  ->on('enseignants')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('classes', function (Blueprint $table) {
            // Supprimer la clé étrangère d'abord
            $table->dropForeign(['enseignant_id']);

            // Puis supprimer la colonne
            $table->dropColumn('enseignant_id');
        });
    }
}
