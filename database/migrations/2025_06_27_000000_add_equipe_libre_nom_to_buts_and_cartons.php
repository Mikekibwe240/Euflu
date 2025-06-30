<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('buts', function (Blueprint $table) {
            $table->string('equipe_libre_nom')->nullable()->after('equipe_id');
        });
        Schema::table('cartons', function (Blueprint $table) {
            $table->string('equipe_libre_nom')->nullable()->after('equipe_id');
        });
    }
    public function down(): void
    {
        Schema::table('buts', function (Blueprint $table) {
            $table->dropColumn('equipe_libre_nom');
        });
        Schema::table('cartons', function (Blueprint $table) {
            $table->dropColumn('equipe_libre_nom');
        });
    }
};
