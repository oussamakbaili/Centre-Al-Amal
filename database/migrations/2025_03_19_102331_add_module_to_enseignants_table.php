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
            $table->string('module')->nullable(); // tu peux retirer nullable si obligatoire
        });
    }

    public function down()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->dropColumn('module');
        });
    }

};
