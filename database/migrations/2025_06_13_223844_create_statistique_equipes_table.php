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
        Schema::create('statistique_equipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');
            $table->foreignId('saison_id')->constrained('saisons')->onDelete('cascade');
            $table->unsignedInteger('points')->default(0);
            $table->unsignedInteger('victoires')->default(0);
            $table->unsignedInteger('nuls')->default(0);
            $table->unsignedInteger('defaites')->default(0);
            $table->unsignedInteger('buts_pour')->default(0);
            $table->unsignedInteger('buts_contre')->default(0);
            $table->unsignedInteger('cartons_jaunes')->default(0);
            $table->unsignedInteger('cartons_rouges')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistique_equipes');
    }
};
