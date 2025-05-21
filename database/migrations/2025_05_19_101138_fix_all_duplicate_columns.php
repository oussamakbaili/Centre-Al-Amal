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
    // Liste de toutes les corrections
    $tables = [
        'absences' => ['etat'],
        'emploi_du_temps' => ['salle'],
        'enseignants' => ['module_id']
    ];

    foreach ($tables as $table => $columns) {
        foreach ($columns as $column) {
            if (Schema::hasColumn($table, $column)) {
                Schema::table($table, function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
}

public function down()
{
    // Ne rien faire - cette migration est un correctif ponctuel
}
};
