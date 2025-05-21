<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    if (!Schema::hasColumn('absences', 'etat')) {
        Schema::table('absences', function (Blueprint $table) {
            $table->string('etat')->default('Non justifié')->after('date_absence');
        });
    }
}

public function down()
{
    Schema::table('absences', function (Blueprint $table) {
        $table->dropColumn('etat');
    });
}
};
