<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // First, drop the foreign key if it exists
        Schema::table('presences', function (Blueprint $table) {
            $table->dropForeign(['seance_id']);
        });

        // Then modify the table
        Schema::table('presences', function (Blueprint $table) {
            // Modify seance_id to be nullable
            $table->unsignedBigInteger('seance_id')->nullable()->change();
            
            // Add new columns
            $table->unsignedBigInteger('emploi_du_temps_id')->nullable()->after('seance_id');
            $table->enum('type', ['emploi', 'seance'])->default('seance')->after('emploi_du_temps_id');
            $table->date('date')->nullable()->after('type');
            
            // Add foreign keys
            $table->foreign('seance_id')
                  ->references('id')
                  ->on('seances')
                  ->onDelete('cascade');
                  
            $table->foreign('emploi_du_temps_id')
                  ->references('id')
                  ->on('emploi_du_temps')
                  ->onDelete('cascade');
        });

        // Update existing records if any
        DB::statement("
            UPDATE presences p
            INNER JOIN seances s ON s.id = p.seance_id
            SET p.type = 'seance',
                p.date = s.date
            WHERE p.seance_id IS NOT NULL
        ");
    }

    public function down()
    {
        Schema::table('presences', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['emploi_du_temps_id']);
            $table->dropForeign(['seance_id']);
            
            // Drop new columns
            $table->dropColumn(['emploi_du_temps_id', 'type', 'date']);
            
            // Restore seance_id to not nullable
            $table->unsignedBigInteger('seance_id')->change();
            
            // Restore foreign key
            $table->foreign('seance_id')
                  ->references('id')
                  ->on('seances')
                  ->onDelete('cascade');
        });
    }
};