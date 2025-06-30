<?php

namespace Database\Seeders;

use App\Models\Saison;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Saison::create([
            'nom' => 'Saison 2024-2025',
            'date_debut' => '2024-09-01',
            'date_fin' => '2025-06-30',
            'etat' => 'ouverte',
        ]);
    }
}
