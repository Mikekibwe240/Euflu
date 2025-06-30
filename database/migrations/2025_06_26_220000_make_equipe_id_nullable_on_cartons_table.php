<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('cartons', function (Blueprint $table) {
            $table->dropForeign(['equipe_id']);
            $table->unsignedBigInteger('equipe_id')->nullable()->change();
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::table('cartons', function (Blueprint $table) {
            $table->dropForeign(['equipe_id']);
            $table->unsignedBigInteger('equipe_id')->nullable(false)->change();
            $table->foreign('equipe_id')->references('id')->on('equipes')->onDelete('cascade');
        });
    }
};
