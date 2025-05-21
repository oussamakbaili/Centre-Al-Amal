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
    if (!Schema::hasColumn('emploi_du_temps', 'salle')) {
        Schema::table('emploi_du_temps', function (Blueprint $table) {
            $table->string('salle')->nullable()->after('heure_fin');
        });
    }
}

public function down()
{
    Schema::table('emploi_du_temps', function (Blueprint $table) {
        $table->dropColumn('salle');
    });
}

};
