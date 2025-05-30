<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('absences', 'etat')) {
            Schema::table('absences', function (Blueprint $table) {
                $table->string('etat')->default('Non justifié')->after('date_absence');
            });
        }
        
        // Also ensure type column exists if not already there
        if (!Schema::hasColumn('absences', 'type')) {
            Schema::table('absences', function (Blueprint $table) {
                $table->string('type')->default('Étudiant')->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('absences', 'etat')) {
            Schema::table('absences', function (Blueprint $table) {
                $table->dropColumn('etat');
            });
        }
        
        if (Schema::hasColumn('absences', 'type')) {
            Schema::table('absences', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }
    }
};
