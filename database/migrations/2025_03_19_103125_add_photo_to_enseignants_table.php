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
        Schema::table('enseignants', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('email'); // après 'email' pour la lisibilité
        });
    }

    public function down()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->dropColumn('photo');
        });
    }

};
