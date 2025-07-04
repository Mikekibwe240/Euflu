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
        Schema::create('match_remplacements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('match_effectif_id');
            $table->unsignedBigInteger('joueur_remplacant_id');
            $table->unsignedBigInteger('joueur_remplace_id');
            $table->unsignedTinyInteger('minute')->nullable();
            $table->timestamps();
            $table->foreign('match_effectif_id')->references('id')->on('match_effectifs')->onDelete('cascade');
            $table->foreign('joueur_remplacant_id')->references('id')->on('joueurs')->onDelete('cascade');
            $table->foreign('joueur_remplace_id')->references('id')->on('joueurs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_remplacements');
    }
};
