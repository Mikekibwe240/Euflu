<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->string('type_rencontre')->nullable()->after('journee');
        });
    }

    public function down()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropColumn('type_rencontre');
        });
    }
};
