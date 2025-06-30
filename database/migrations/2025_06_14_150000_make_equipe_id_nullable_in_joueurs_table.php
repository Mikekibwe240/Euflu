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
        Schema::table('joueurs', function (Blueprint $table) {
            $table->foreignId('equipe_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('joueurs', function (Blueprint $table) {
            $table->foreignId('equipe_id')->nullable(false)->change();
        });
    }
};
