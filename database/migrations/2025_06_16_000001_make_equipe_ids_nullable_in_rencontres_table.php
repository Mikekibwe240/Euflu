<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->unsignedBigInteger('equipe1_id')->nullable()->change();
            $table->unsignedBigInteger('equipe2_id')->nullable()->change();
        });
    }
    public function down()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->unsignedBigInteger('equipe1_id')->nullable(false)->change();
            $table->unsignedBigInteger('equipe2_id')->nullable(false)->change();
        });
    }
};
