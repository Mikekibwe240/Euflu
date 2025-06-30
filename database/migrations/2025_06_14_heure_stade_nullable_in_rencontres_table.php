<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->time('heure')->nullable()->change();
            $table->string('stade')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->time('heure')->nullable(false)->change();
            $table->string('stade')->nullable(false)->change();
        });
    }
};
