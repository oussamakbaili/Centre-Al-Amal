<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
{
    // Étape 1 : ajouter la colonne nullable
    Schema::table('notes', function (Blueprint $table) {
        $table->foreignId('enseignant_id')
              ->nullable()
              ->constrained('enseignants')
              ->onDelete('set null');
    });

    // Étape 2 : assigner un enseignant par défaut si possible
    $defaultEnseignant = DB::table('enseignants')->first();

    if ($defaultEnseignant) {
        DB::table('notes')->update(['enseignant_id' => $defaultEnseignant->id]);
    }
    // Sinon, la colonne reste nullable
}

public function down()
{
    Schema::table('notes', function (Blueprint $table) {
        $table->dropForeign(['enseignant_id']);
        $table->dropColumn('enseignant_id');
    });
}
};
