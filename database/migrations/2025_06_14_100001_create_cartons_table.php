<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cartons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rencontre_id')->constrained('rencontres')->onDelete('cascade');
            $table->foreignId('joueur_id')->constrained('joueurs')->onDelete('cascade');
            $table->foreignId('equipe_id')->constrained('equipes')->onDelete('cascade');
            $table->enum('type', ['jaune', 'rouge']);
            $table->unsignedSmallInteger('minute')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('cartons');
    }
};
