<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixGroupeIdInEtudiantsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('etudiants')) {
            // Supprimer la colonne si elle existe (évite l'erreur de contrainte)
            if (Schema::hasColumn('etudiants', 'groupe_id')) {
                Schema::table('etudiants', function (Blueprint $table) {
                    // Laravel va échouer ici si la contrainte n'existe pas, donc on ne fait que drop la colonne
                    $table->dropColumn('groupe_id');
                });
            }

            // Ajouter à nouveau la colonne
            Schema::table('etudiants', function (Blueprint $table) {
                $table->unsignedBigInteger('groupe_id')->nullable()->after('id');
            });

            // Remplir avec un groupe par défaut si dispo
            if (Schema::hasTable('groupes') && DB::table('groupes')->exists()) {
                $defaultGroupId = DB::table('groupes')->value('id');
                DB::table('etudiants')->update(['groupe_id' => $defaultGroupId]);
            }

            // Ajouter la contrainte proprement
            Schema::table('etudiants', function (Blueprint $table) {
                $table->foreign('groupe_id')->references('id')->on('groupes')->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('etudiants') && Schema::hasColumn('etudiants', 'groupe_id')) {
            Schema::table('etudiants', function (Blueprint $table) {
                // Pour éviter l’erreur, on utilise un try/catch ici
                try {
                    $table->dropForeign(['groupe_id']);
                } catch (\Exception $e) {
                    // Pas grave si la contrainte n'existe pas
                }

                $table->dropColumn('groupe_id');
            });
        }
    }
}
