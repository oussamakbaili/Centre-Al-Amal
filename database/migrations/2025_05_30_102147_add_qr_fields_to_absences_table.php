<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('absences', function (Blueprint $table) {
            if (!Schema::hasColumn('absences', 'emploi_id')) {
                $table->unsignedBigInteger('emploi_id')->nullable()->after('enseignant_id');
            }

            if (!Schema::hasColumn('absences', 'scanned_at')) {
                $table->timestamp('scanned_at')->nullable()->after('motif');
            }

            if (!Schema::hasColumn('absences', 'heure_cours')) {
                $table->time('heure_cours')->nullable()->after('scanned_at');
            }

            if (!Schema::hasColumn('absences', 'module_nom')) {
                $table->string('module_nom')->nullable()->after('heure_cours');
            }

            if (!Schema::hasColumn('absences', 'salle')) {
                $table->string('salle')->nullable()->after('module_nom');
            }
        });

        // Ajout de la clé étrangère (en dehors de la vérification de colonnes)
        if (Schema::hasTable('emplois') && Schema::hasColumn('absences', 'emploi_id')) {
            Schema::table('absences', function (Blueprint $table) {
                try {
                    $table->foreign('emploi_id')->references('id')->on('emplois')->onDelete('set null');
                } catch (\Exception $e) {
                    // Ignore si erreur
                }
            });
        }
    }

    public function down()
    {
        Schema::table('absences', function (Blueprint $table) {
            try {
                $table->dropForeign(['emploi_id']);
            } catch (\Exception $e) {
                // Ignore si déjà supprimé
            }

            if (Schema::hasColumn('absences', 'emploi_id')) $table->dropColumn('emploi_id');
            if (Schema::hasColumn('absences', 'scanned_at')) $table->dropColumn('scanned_at');
            if (Schema::hasColumn('absences', 'heure_cours')) $table->dropColumn('heure_cours');
            if (Schema::hasColumn('absences', 'module_nom')) $table->dropColumn('module_nom');
            if (Schema::hasColumn('absences', 'salle')) $table->dropColumn('salle');
        });
    }
};
