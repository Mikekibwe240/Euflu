<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipe;
use App\Models\Pool;
use App\Models\Saison;

class EquipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saison = Saison::first();
        $poolA = Pool::where('nom', 'A')->first();
        $poolB = Pool::where('nom', 'B')->first();
        // POOL A
        $equipesA = [
            'EAGLES JOLI SITE', 'FC AIGLE VOLANT', 'FC FREEDOM', 'WARRIOR AC', 'RC KATANGA STAR',
            'ABC KATUMBI', 'FC PASSION YETU', 'FC KINDELE', 'US HATARI', 'FC HONORABLE II',
            'FC LUMUMBA', 'AC FURAH', 'FC MICHEL', 'FC SUPER STARS'
        ];
        // POOL B (doublons supprimés)
        $equipesB = [
            'BLESSING FC', 'AC BAZANO', 'FC CAROLE', 'FC UMOJA', 'CS KATHY', 'FC LAURENT',
            'TP ROCHER', 'FC CORBEAU', 'AC GECOS', 'FC St PIERRE', 'CS NX TALENT',
            'FC BRASIMBA', 'RED EAGLES J.S'
        ];
        // Ajout FC St ESPRIT dans Pool B
        $equipesB[] = 'FC St ESPRIT';
        $coachs = ['Mwamba', 'Ilunga', 'Kabasele', 'Mutombo', 'Kasongo', 'Kabongo', 'Lutumba', 'Makiese', 'Mbuyi', 'Ngoy', 'Mundele', 'Kalonji', 'Banza', 'Kitenge', 'Kanku', 'Moke', 'Bokolo', 'Kisimba', 'Kibonge', 'Kanda', 'Mawete', 'Kitenge', 'Kanku', 'Boketshu', 'Mabiala', 'Kitenge', 'Kanku', 'Boketshu', 'Mabiala'];
        shuffle($coachs);
        $logo = null; // ou 'default.png' si tu veux une image par défaut
        foreach ($equipesA as $i => $nom) {
            Equipe::updateOrCreate([
                'nom' => $nom,
                'pool_id' => $poolA->id,
                'saison_id' => $saison->id
            ], [
                'coach' => $coachs[$i % count($coachs)],
                'logo' => $logo
            ]);
        }
        foreach ($equipesB as $i => $nom) {
            Equipe::updateOrCreate([
                'nom' => $nom,
                'pool_id' => $poolB->id,
                'saison_id' => $saison->id
            ], [
                'coach' => $coachs[($i+14) % count($coachs)],
                'logo' => $logo
            ]);
        }
    }
}
