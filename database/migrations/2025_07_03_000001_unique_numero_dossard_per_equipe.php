<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('joueurs', function (Blueprint $table) {
            $table->unique(['equipe_id', 'numero_dossard']);
        });
    }
    public function down(): void
    {
        Schema::table('joueurs', function (Blueprint $table) {
            $table->dropUnique(['equipe_id', 'numero_dossard']);
        });
    }
};
