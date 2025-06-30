<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Cette migration est neutralisée car la colonne role existe déjà dans la table users.
return new class extends Migration {
    public function up(): void
    {
        // Rien à faire
    }
    public function down(): void
    {
        // Rien à faire
    }
};
