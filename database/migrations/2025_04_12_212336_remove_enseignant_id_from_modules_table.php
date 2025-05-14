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
    Schema::table('modules', function (Blueprint $table) {
        // Supprimer d'abord la contrainte de clé étrangère
        $table->dropForeign(['enseignant_id']);

        // Puis supprimer la colonne
        $table->dropColumn('enseignant_id');
    });
}

public function down()
{
    Schema::table('modules', function (Blueprint $table) {
        $table->unsignedBigInteger('enseignant_id')->nullable();

        // Restaurer la contrainte si besoin
        $table->foreign('enseignant_id')->references('id')->on('enseignants')->onDelete('set null');
    });
}


};
