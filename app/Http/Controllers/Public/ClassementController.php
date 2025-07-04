<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\StatistiqueEquipe;
use App\Models\Saison;

class ClassementController extends Controller
{
    public function index()
    {
        $saison = \App\Models\Saison::where('active', 1)->first();
        $poules = \App\Models\Pool::with(['equipes.statsSaison' => function($q) use ($saison) {
            $q->where('saison_id', $saison?->id);
        }, 'equipes'])->orderBy('nom')->get();
        // Classement par pool
        foreach ($poules as $poule) {
            $classement = $poule->equipes->map(function($equipe) {
                $stats = $equipe->statsSaison()->first();
                return (object) [
                    'equipe' => $equipe,
                    'mj' => ($stats?->victoires ?? 0) + ($stats?->nuls ?? 0) + ($stats?->defaites ?? 0),
                    'mg' => $stats?->victoires ?? 0,
                    'mp' => $stats?->defaites ?? 0,
                    'mn' => $stats?->nuls ?? 0,
                    'bp' => $stats?->buts_pour ?? 0,
                    'bc' => $stats?->buts_contre ?? 0,
                    'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                    'points' => $stats?->points ?? 0,
                ];
            })->sortByDesc('points')->values();
            $poule->classement = $classement;
        }
        // Classement fair-play (toutes équipes, tri par total cartons)
        $fairplay = Equipe::with(['statsSaison' => function($q) use ($saison) {
            $q->where('saison_id', $saison?->id);
        }])->get()->map(function($equipe) {
            $stats = $equipe->statsSaison()->first();
            return (object) [
                'equipe' => $equipe,
                'cartons_jaunes' => $stats?->cartons_jaunes ?? 0,
                'cartons_rouges' => $stats?->cartons_rouges ?? 0,
                'total_cartons' => ($stats?->cartons_jaunes ?? 0) + ($stats?->cartons_rouges ?? 0),
            ];
        })->sortBy('total_cartons')->values();
        return view('public.classement', compact('poules', 'fairplay'));
    }
}
