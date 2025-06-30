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
        Schema::create('saisons', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->enum('etat', ['ouverte', 'cloturee'])->default('ouverte');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saisons');
    }
};
