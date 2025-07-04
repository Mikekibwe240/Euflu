<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\But;
use App\Models\Joueur;
use App\Models\Equipe;
use App\Models\Pool;

class ClassementButeursAdminController extends Controller
{
    public function index($poolId)
    {
        $pool = Pool::with('equipes.joueurs.buts')->findOrFail($poolId);
        // Récupérer tous les joueurs des équipes du pool
        $joueurs = Joueur::whereIn('equipe_id', $pool->equipes->pluck('id'))
            ->withCount(['buts'])
            ->having('buts_count', '>', 0)
            ->orderByDesc('buts_count')
            ->get();
        return view('admin.classement_buteurs', [
            'buteurs' => $joueurs,
            'pool' => $pool
        ]);
    }
}