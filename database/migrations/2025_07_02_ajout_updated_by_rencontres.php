<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->unsignedBigInteger('updated_by')->nullable()->after('mvp_libre_equipe');
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }
    public function down()
    {
        Schema::table('rencontres', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn('updated_by');
        });
    }
};
