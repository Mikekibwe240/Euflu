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
        Schema::create('rencontres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pool_id')->constrained('pools')->onDelete('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->foreignId('equipe1_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('equipe2_id')->constrained('equipes')->onDelete('cascade');
            $table->date('date');
            $table->time('heure');
            $table->string('stade');
            $table->unsignedTinyInteger('journee')->nullable();
            $table->unsignedInteger('score_equipe1')->nullable();
            $table->unsignedInteger('score_equipe2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rencontres');
    }
};
