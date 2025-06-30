<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->foreignId('mvp_id')->nullable()->constrained('joueurs')->nullOnDelete();
        });
    }
    public function down(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropForeign(['mvp_id']);
            $table->dropColumn('mvp_id');
        });
    }
};
