<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('categories');
    }

    public function down(): void
    {
        // Optionnel : vous pouvez remettre les schémas ici si besoin
    }
};
