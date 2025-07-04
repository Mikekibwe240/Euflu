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
            $table->string('numero_licence')->nullable()->after('photo');
            $table->string('numero_dossard')->nullable()->after('numero_licence');
            $table->string('nationalite')->nullable()->after('numero_dossard');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('joueurs', function (Blueprint $table) {
            $table->dropColumn(['numero_licence', 'numero_dossard', 'nationalite']);
        });
    }
};
