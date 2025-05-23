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
    if (!Schema::hasTable('etudiant_module')) {
        Schema::create('etudiant_module', function (Blueprint $table) {
            $table->foreignId('etudiant_id')->constrained()->onDelete('cascade');
            $table->foreignId('module_id')->constrained()->onDelete('cascade');
            $table->primary(['etudiant_id', 'module_id']);
            $table->timestamps();
        });
    }
}

public function down()
{
    Schema::dropIfExists('etudiant_module');
}
};
