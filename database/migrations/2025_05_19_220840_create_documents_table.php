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
    Schema::create('documents', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('enseignant_id');
        $table->string('titre');
        $table->text('contenu')->nullable(); // Pour du texte
        $table->string('fichier')->nullable(); // Pour les fichiers
        $table->timestamps();

        $table->foreign('enseignant_id')->references('id')->on('enseignants')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
