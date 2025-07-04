<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Pool;
use App\Models\Saison;
use App\Helpers\SaisonHelper;
use Illuminate\Http\Request;

class ClassementButeursController extends Controller
{
    public function index(Request $request)
    {
        $saison = SaisonHelper::getActiveSaison($request);
        $pools = $saison ? $saison->pools()->with(['equipes.joueurs.buts', 'equipes.joueurs.equipe'])->get() : collect();
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        // Pour chaque pool, on récupère les buteurs triés par nombre de buts
        foreach ($pools as $pool) {
            $buteurs = $pool->equipes->flatMap(function($equipe) {
                return $equipe->joueurs;
            });
            $buteurs = $buteurs->map(function($joueur) {
                $joueur->buts_count = $joueur->buts->count();
                return $joueur;
            })->sortByDesc('buts_count')->filter(fn($j) => $j->buts_count > 0)->values();
            $pool->buteurs = $buteurs;
        }
        return view('public.buteurs', compact('pools', 'saison', 'saisons'));
    }
}
