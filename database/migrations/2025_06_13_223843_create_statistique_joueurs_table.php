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
        Schema::create('statistique_joueurs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joueur_id')->constrained('joueurs')->onDelete('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->unsignedInteger('buts')->default(0);
            $table->unsignedInteger('cartons_jaunes')->default(0);
            $table->unsignedInteger('cartons_rouges')->default(0);
            $table->unsignedInteger('mvp')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistique_joueurs');
    }
};
