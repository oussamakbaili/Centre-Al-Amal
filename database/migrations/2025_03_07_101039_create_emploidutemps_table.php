<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('emploi_du_temps', function (Blueprint $table) { 
            $table->id();
            $table->string('jour'); // Lundi, Mardi, etc.
            $table->string('heure_debut');
            $table->string('heure_fin');
            $table->string('salle')->nullable();
            $table->string('matiere');
            $table->unsignedBigInteger('enseignant_id')->nullable();
            $table->unsignedBigInteger('etudiant_id')->nullable();
            $table->timestamps();

            $table->foreign('enseignant_id')->references('id')->on('enseignants')->onDelete('cascade');
            $table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
        });
    }

    public function down() {
        Schema::dropIfExists('emploi_du_temps'); 
    }
};