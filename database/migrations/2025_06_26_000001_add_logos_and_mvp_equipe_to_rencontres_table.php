<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->string('logo_equipe1_libre')->nullable()->after('equipe1_libre');
            $table->string('logo_equipe2_libre')->nullable()->after('equipe2_libre');
            $table->string('mvp_libre_equipe')->nullable()->after('mvp_libre');
        });
    }

    public function down()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropColumn(['logo_equipe1_libre', 'logo_equipe2_libre', 'mvp_libre_equipe']);
        });
    }
};
