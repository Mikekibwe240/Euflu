<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rencontre;
use App\Models\Pool;
use App\Models\Saison;
use App\Models\Equipe;

class RencontreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saison = Saison::first();
        $poolA = Pool::where('nom', 'A')->first();
        $equipe1 = Equipe::where('nom', 'Lions')->first();
        $equipe2 = Equipe::where('nom', 'Tigres')->first();
        Rencontre::create([
            'pool_id' => $poolA->id,
            'saison_id' => $saison->id,
            'equipe1_id' => $equipe1->id,
            'equipe2_id' => $equipe2->id,
            'date' => '2024-09-10',
            'heure' => '15:00:00',
            'stade' => 'Stade A',
            'journee' => 1,
            'score_equipe1' => null,
            'score_equipe2' => null,
        ]);
    }
}
