<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipe;
use App\Models\Pool;
use App\Models\Saison;

class EquipePoolSeeder extends Seeder
{
    public function run()
    {
        $saison = Saison::where('etat', 'ouverte')->first();
        $coachs = [
            'Mabiala', 'Kabasele', 'Makengo', 'Banza', 'Kalonji', 'Mabika', 'Mutombo', 'Kitenge', 'Mwamba', 'Kabongo', 'Lukusa', 'Mbuyi', 'Ngoy', 'Ilunga',
            'Kouadio', 'Traoré', 'Diouf', 'Sankara', 'Bamba', 'Kouamé', 'Sow', 'Cissé', 'Keita', 'Dieng', 'Sylla', 'Camara', 'Fofana', 'Konaté', 'Touré', 'Diallo'
        ];
        $coachIndex = 0;
        // POOL A
        $poolA = Pool::where('nom', 'A')->first();
        $equipesA = [
            'EAGLES JOLI SITE',
            'FC AIGLE VOLANT',
            'FC FREEDOM',
            'WARRIOR AC',
            'RC KATANGA STAR',
            'ABC KATUMBI',
            'FC PASSION YETU',
            'FC KINDELE',
            'US HATARI',
            'FC HONORABLE II',
            'FC LUMUMBA',
            'AC FURAH',
            'FC MICHEL',
            'FC SUPER STARS',
        ];
        foreach ($equipesA as $nom) {
            Equipe::firstOrCreate([
                'nom' => $nom,
                'pool_id' => $poolA->id,
                'saison_id' => $saison->id,
                'coach' => $coachs[$coachIndex++ % count($coachs)],
                'logo' => null
            ]);
        }
        // POOL B
        $poolB = Pool::where('nom', 'B')->first();
        $equipesB = [
            'BLESSING FC', 'AC BAZANO',
            'FC CAROLE', 'FC UMOJA',
            'CS KATHY', 'FC LAURENT',
            'TP ROCHER', 'FC CORBEAU',
            'AC GECOS', 'FC St PIERRE',
            'CS NX TALENT',
            'BLESSING FC',
            'FC BRASIMBA',
            'RED EAGLES J.S',
        ];
        foreach ($equipesB as $nom) {
            Equipe::firstOrCreate([
                'nom' => $nom,
                'pool_id' => $poolB->id,
                'saison_id' => $saison->id,
                'coach' => $coachs[$coachIndex++ % count($coachs)],
                'logo' => null
            ]);
        }
    }
}
