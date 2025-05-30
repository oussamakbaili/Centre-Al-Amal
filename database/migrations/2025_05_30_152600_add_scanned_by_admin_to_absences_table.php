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
    Schema::table('absences', function (Blueprint $table) {
        $table->boolean('scanned_by_admin')->default(false);
        $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('absences', function (Blueprint $table) {
        $table->dropColumn('scanned_by_admin');
        $table->dropForeign(['admin_id']);
        $table->dropColumn('admin_id');
    });
}
};
