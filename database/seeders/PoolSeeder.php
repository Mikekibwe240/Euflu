<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pool;
use App\Models\Saison;

class PoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saison = Saison::first();
        Pool::create(['nom' => 'A', 'saison_id' => $saison->id]);
        Pool::create(['nom' => 'B', 'saison_id' => $saison->id]);
    }
}
