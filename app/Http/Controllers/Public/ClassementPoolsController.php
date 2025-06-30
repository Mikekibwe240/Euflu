<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pool;

class ClassementPoolsController extends Controller
{
    public function index()
    {
        $poules = Pool::with(['equipes.statsSaison' => function($q) {
            $q->orderByDesc('points');
        }, 'equipes'])->orderBy('nom')->get();
        // Pour chaque poule, on trie les équipes par points et on prépare le classement
        foreach ($poules as $poule) {
            $classement = $poule->equipes->map(function($equipe) {
                $stats = $equipe->statsSaison;
                return (object) [
                    'equipe' => $equipe,
                    'mj' => $stats?->mj ?? 0,
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
        return view('public.classement_pools', compact('poules'));
    }
}
