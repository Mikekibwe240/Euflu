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
        Schema::table('rencontres', function (Blueprint $table) {
            $table->string('equipe1_libre')->nullable()->after('equipe1_id');
            $table->string('equipe2_libre')->nullable()->after('equipe2_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropColumn(['equipe1_libre', 'equipe2_libre']);
        });
    }
};
