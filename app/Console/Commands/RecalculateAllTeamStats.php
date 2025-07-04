<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipe;
use App\Models\Saison;
use App\Helpers\StatistiquesHelper;

class RecalculateAllTeamStats extends Command
{
    protected $signature = 'euflu:recalc-stats';
    protected $description = 'Recalcule toutes les statistiques d\'équipes pour chaque saison';

    public function handle()
    {
        $saisons = Saison::all();
        $this->info('Recalcul des statistiques pour toutes les équipes et saisons...');
        foreach ($saisons as $saison) {
            $equipes = Equipe::where('saison_id', $saison->id)->get();
            foreach ($equipes as $equipe) {
                StatistiquesHelper::updateStatsForTeam($equipe->id, $saison->id);
                $this->line("Equipe #{$equipe->id} ({$equipe->nom}) - Saison #{$saison->id} : OK");
            }
        }
        $this->info('Recalcul terminé.');
        return 0;
    }
}
