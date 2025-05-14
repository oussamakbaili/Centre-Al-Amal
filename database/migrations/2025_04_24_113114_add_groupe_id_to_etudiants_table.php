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
        if (!Schema::hasColumn('etudiants', 'groupe_id')) {
            Schema::table('etudiants', function (Blueprint $table) {
                $table->unsignedBigInteger('groupe_id')->nullable()->after('id');
            
                $defaultGroupId = DB::table('groupes')->value('id') ?? null;
                if ($defaultGroupId) {
                    DB::table('etudiants')->update(['groupe_id' => $defaultGroupId]);
                }
            
                if (Schema::hasTable('groupes') && DB::table('groupes')->exists()) {
                    $table->foreign('groupe_id')->references('id')->on('groupes')
                          ->onDelete('cascade');
                }
            });
        }
    }

    public function down()
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropForeign(['groupe_id']);
            $table->dropColumn('groupe_id');
        });
    }
};
