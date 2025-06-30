<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Joueur;
use App\Models\Equipe;
use App\Models\Saison;
use Illuminate\Support\Arr;

class JoueurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $saison = Saison::first();
        $equipes = Equipe::all();
        $postes = [
            'GB', 'GB', 'GB', // 3 gardiens
            'DD', 'DG', 'DC', 'DC', // 4 défenseurs
            'DD', 'DG', 'DC', 'DC', // 4 défenseurs (remplaçants)
            'MD', 'MG', 'MO', 'MDC', 'MDC', // 5 milieux
            'MD', 'MG', 'MO', 'MDC', 'MDC', // 5 milieux (remplaçants)
            'AD', 'AG', 'BU', 'BU', // 4 attaquants
        ];
        $prenoms = ['Arsène', 'Blaise', 'Chadrack', 'Désiré', 'Emery', 'Fiston', 'Gloire', 'Héritier', 'Isaac', 'Joël', 'Kévin', 'Landry', 'Merveille', 'Noé', 'Oscar', 'Prince', 'Quentin', 'Ricky', 'Samuel', 'Trésor', 'Ulrich', 'Vainqueur', 'Wilfried'];
        $noms = ['Mwamba', 'Kasongo', 'Ilunga', 'Kabongo', 'Mutombo', 'Lukusa', 'Makiese', 'Kabasele', 'Kalala', 'Mbuyi', 'Ngoy', 'Kalonji', 'Kanku', 'Kitenge', 'Kashala', 'Mundele', 'Kambale', 'Kalonji', 'Kanku', 'Kitenge', 'Kashala', 'Mundele'];
        $postnoms = ['Kabasele', 'Mutombo', 'Kabongo', 'Kasongo', 'Lutumba', 'Makiese', 'Mbuyi', 'Ngoy', 'Mundele', 'Kalonji', 'Banza', 'Kitenge', 'Kanku', 'Bokolo', 'Kisimba', 'Kibonge', 'Kanda', 'Mawete', 'Boketshu', 'Mabiala'];
        foreach ($equipes as $equipe) {
            $prenomsEquipe = Arr::shuffle($prenoms);
            $nomsEquipe = Arr::shuffle($noms);
            $postnomsEquipe = Arr::shuffle($postnoms);
            for ($i = 0; $i < 22; $i++) {
                $poste = $postes[$i] ?? 'BU';
                $prenom = $prenomsEquipe[$i % count($prenomsEquipe)];
                $nom = $nomsEquipe[$i % count($nomsEquipe)] . ' ' . $postnomsEquipe[$i % count($postnomsEquipe)];
                // Date naissance : majorité < 27 ans (championnat jeunes)
                $annee = rand(1999, 2007); // 2025-27 = 1998, mais on met 1999-2007 pour majorité < 27 ans
                $mois = rand(1, 12);
                $jour = rand(1, 28);
                $date_naissance = sprintf('%04d-%02d-%02d', $annee, $mois, $jour);
                Joueur::create([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'date_naissance' => $date_naissance,
                    'poste' => $poste,
                    'equipe_id' => $equipe->id,
                    'saison_id' => $saison->id,
                    'photo' => null,
                ]);
            }
        }
    }
}
