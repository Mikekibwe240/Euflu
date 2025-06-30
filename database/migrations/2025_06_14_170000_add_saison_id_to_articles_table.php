<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->foreignId('saison_id')->nullable()->constrained('saisons')->onDelete('set null')->after('id');
        });
    }
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropForeign(['saison_id']);
            $table->dropColumn('saison_id');
        });
    }
};
