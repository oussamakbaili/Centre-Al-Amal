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
    Schema::create('preinscriptions', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('prenom')->nullable();
        $table->string('email');
        $table->string('adresse');
        $table->string('telephone');
        $table->date('date_naissance');
        $table->string('cin');
        $table->string('image');
        $table->string('niveau');
        $table->enum('statut', ['en_attente', 'accepte', 'refuse'])->default('en_attente');
        $table->timestamps();
    });
}   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preinscriptions');
    }
};
