<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasColumn('modules', 'enseignant_id')) {
        Schema::table('modules', function (Blueprint $table) {
            $table->unsignedBigInteger('enseignant_id')->nullable();
            
            // Ne pas ajouter la contrainte tout de suite
        });
    }
}

public function down()
{
    if (Schema::hasColumn('modules', 'enseignant_id')) {
        Schema::table('modules', function (Blueprint $table) {
            // Supprimer d'abord la contrainte si elle existe
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $foreignKeys = $sm->listTableForeignKeys('modules');
            
            foreach ($foreignKeys as $fk) {
                if (in_array('enseignant_id', $fk->getLocalColumns())) {
                    $table->dropForeign([$fk->getLocalColumns()[0]]);
                    break;
                }
            }
            
            $table->dropColumn('enseignant_id');
        });
    }
}
};
