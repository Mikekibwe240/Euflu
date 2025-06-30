<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('buts', function (Blueprint $table) {
            $table->dropForeign(['joueur_id']);
            $table->unsignedBigInteger('joueur_id')->nullable()->change();
            $table->foreign('joueur_id')->references('id')->on('joueurs')->onDelete('cascade');
        });
        Schema::table('cartons', function (Blueprint $table) {
            $table->dropForeign(['joueur_id']);
            $table->unsignedBigInteger('joueur_id')->nullable()->change();
            $table->foreign('joueur_id')->references('id')->on('joueurs')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('buts', function (Blueprint $table) {
            $table->dropForeign(['joueur_id']);
            $table->unsignedBigInteger('joueur_id')->nullable(false)->change();
            $table->foreign('joueur_id')->references('id')->on('joueurs')->onDelete('cascade');
        });
        Schema::table('cartons', function (Blueprint $table) {
            $table->dropForeign(['joueur_id']);
            $table->unsignedBigInteger('joueur_id')->nullable(false)->change();
            $table->foreign('joueur_id')->references('id')->on('joueurs')->onDelete('cascade');
        });
    }
};
