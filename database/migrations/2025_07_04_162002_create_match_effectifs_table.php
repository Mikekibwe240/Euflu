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
        Schema::create('match_effectifs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rencontre_id');
            $table->unsignedBigInteger('equipe_id');
            $table->timestamps();
            $table->foreign('rencontre_id')->references('id')->on('rencontres')->onDelete('cascade');
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_effectifs');
    }
};
