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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password'); // Mot de passe sécurisé
            $table->string('cin')->unique(); // Carte d'identité nationale
            $table->date('date_naissance');
            $table->text('adresse');
            $table->string('telephone');
            $table->string('image')->nullable(); // Image de profil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('etudiants');
    }
};
