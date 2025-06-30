<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->string('mvp_libre')->nullable()->after('mvp_id');
        });
    }
    public function down(): void
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropColumn('mvp_libre');
        });
    }
};
