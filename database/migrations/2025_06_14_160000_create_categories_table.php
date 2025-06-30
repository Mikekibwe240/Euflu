<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Création de la table categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->timestamps();
        });
        // Création de la table de pivot article_category
        Schema::create('article_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('article_category');
        Schema::dropIfExists('categories');
    }
};
