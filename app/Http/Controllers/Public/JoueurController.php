<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Joueur;

class JoueurController extends Controller
{
    public function search()
    {
        $q = request('q');
        $top = request('top');
        $saison = \App\Models\Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $pools = $saison ? \App\Models\Pool::where('saison_id', $saison->id)->get() : collect();
        $joueurs = collect();
        if ($top === 'buteurs') {
            foreach ($pools as $pool) {
                $poolJoueurs = \App\Models\Joueur::with(['equipe', 'buts.rencontre'])
                    ->whereHas('equipe', function($q) use ($pool) { $q->where('pool_id', $pool->id); })
                    ->when($q, function($query, $q) {
                        $query->where('nom', 'like', "%$q%")
                              ->orWhere('prenom', 'like', "%$q%");
                    })
                    ->when(request('equipe_id'), function($query, $equipe_id) {
                        $query->where('equipe_id', $equipe_id);
                    })
                    ->when(request('poste'), function($query, $poste) {
                        $query->where('poste', $poste);
                    })
                    ->withCount('buts')->orderByDesc('buts_count')->orderBy('nom')->get();
                foreach ($poolJoueurs as $joueur) {
                    $joueur->matchs_joues = $joueur->buts->pluck('rencontre_id')->unique()->count();
                }
                $joueurs[$pool->nom] = $poolJoueurs;
            }
        } else {
            $joueurs = \App\Models\Joueur::with(['equipe', 'buts.rencontre'])
                ->when($q, function($query, $q) {
                    $query->where('nom', 'like', "%$q%")
                          ->orWhere('prenom', 'like', "%$q%");
                })
                ->when(request('equipe_id'), function($query, $equipe_id) {
                    $query->where('equipe_id', $equipe_id);
                })
                ->when(request('poste'), function($query, $poste) {
                    $query->where('poste', $poste);
                })
                ->orderBy('nom')->get();
            foreach ($joueurs as $joueur) {
                $joueur->matchs_joues = $joueur->buts->pluck('rencontre_id')->unique()->count();
            }
        }
        return view('public.joueurs_search', compact('joueurs', 'top', 'pools'));
    }

    public function show($id)
    {
        $joueur = Joueur::with('equipe')->findOrFail($id);
        return view('public.joueur_show', compact('joueur'));
    }
}
