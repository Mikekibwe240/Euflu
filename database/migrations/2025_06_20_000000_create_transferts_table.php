<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('joueur_id')->constrained('joueurs')->onDelete('cascade');
            $table->foreignId('from_equipe_id')->nullable()->constrained('equipes')->nullOnDelete();
            $table->foreignId('to_equipe_id')->nullable()->constrained('equipes')->nullOnDelete();
            $table->date('date')->nullable();
            $table->string('type')->default('transfert'); // transfert, affectation, liberation
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transferts');
    }
};
