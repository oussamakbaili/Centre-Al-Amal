<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveModuleFromEnseignantsTable extends Migration
{
    public function up()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            // 1. Supprimer la contrainte étrangère d'abord
            $table->dropForeign(['module_id']);

            // 2. Puis supprimer la colonne
            $table->dropColumn('module_id');

            // 3. Supprimer aussi la colonne "module" si elle existe
            if (Schema::hasColumn('enseignants', 'module')) {
                $table->dropColumn('module');
            }
        });
    }

    public function down()
    {
        Schema::table('enseignants', function (Blueprint $table) {
            $table->unsignedBigInteger('module_id')->nullable();

            $table->foreign('module_id')->references('id')->on('modules')->onDelete('set null');

            $table->string('module')->nullable();
        });
    }
};

