<?php

namespace App\Helpers;

use App\Models\Equipe;
use App\Models\Rencontre;
use App\Models\StatistiqueEquipe;

class StatistiquesHelper
{
    /**
     * Recalcule et met à jour les statistiques pour une équipe donnée et une saison donnée
     */
    public static function updateStatsForTeam($equipe_id, $saison_id)
    {
        $equipe = Equipe::find($equipe_id);
        if (!$equipe) return;
        $rencontres = Rencontre::where(function($q) use ($equipe_id) {
            $q->where('equipe1_id', $equipe_id)->orWhere('equipe2_id', $equipe_id);
        })
        ->where('saison_id', $saison_id)
        ->whereNotNull('score_equipe1')
        ->whereNotNull('score_equipe2')
        ->get();
        $points = $victoires = $nuls = $defaites = $buts_pour = $buts_contre = $cartons_jaunes = $cartons_rouges = 0;
        foreach ($rencontres as $match) {
            $isEquipe1 = $match->equipe1_id == $equipe_id;
            $scoreFor = $isEquipe1 ? $match->score_equipe1 : $match->score_equipe2;
            $scoreAgainst = $isEquipe1 ? $match->score_equipe2 : $match->score_equipe1;
            $buts_pour += $scoreFor;
            $buts_contre += $scoreAgainst;
            if ($scoreFor > $scoreAgainst) $victoires++;
            elseif ($scoreFor == $scoreAgainst) $nuls++;
            else $defaites++;
            // Cartons (optionnel, à adapter si tu as des relations)
            if ($match->relationLoaded('cartons')) {
                $cartons_jaunes += $match->cartons->where('joueur.equipe_id', $equipe_id)->where('type', 'jaune')->count();
                $cartons_rouges += $match->cartons->where('joueur.equipe_id', $equipe_id)->where('type', 'rouge')->count();
            }
        }
        $points = $victoires * 3 + $nuls;
        StatistiqueEquipe::updateOrCreate(
            ['equipe_id' => $equipe_id, 'saison_id' => $saison_id],
            [
                'points' => $points,
                'victoires' => $victoires,
                'nuls' => $nuls,
                'defaites' => $defaites,
                'buts_pour' => $buts_pour,
                'buts_contre' => $buts_contre,
                'cartons_jaunes' => $cartons_jaunes,
                'cartons_rouges' => $cartons_rouges,
            ]
        );
    }
}
