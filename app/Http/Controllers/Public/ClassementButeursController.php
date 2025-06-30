<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Joueur;

class ClassementButeursController extends Controller
{
    public function index()
    {
        $buteurs = Joueur::with(['equipe', 'statistiques' => function($q) {
            $q->orderByDesc('buts');
        }])->get()->sortByDesc(fn($j) => $j->statistiques->first()?->buts ?? 0)->values();
        // On ajoute la stat la plus récente à chaque joueur pour la vue
        foreach ($buteurs as $joueur) {
            $joueur->stats = $joueur->statistiques->first();
        }
        return view('public.classement_buteurs', compact('buteurs'));
    }
}
