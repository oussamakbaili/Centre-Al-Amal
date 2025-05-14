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
        Schema::table('etudiants', function (Blueprint $table) {
            $table->string('niveau')->after('image'); // Ajoute la colonne `niveau` après la colonne `image`
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn('niveau'); // Supprime la colonne `niveau` en cas de rollback
        });
    }
};
