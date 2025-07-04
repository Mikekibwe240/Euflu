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
        $saison = \App\Models\Saison::where('active', 1)->first();
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
        $joueur = Joueur::with(['equipe', 'transferts.fromEquipe', 'transferts.toEquipe'])->findOrFail($id);
        return view('public.joueur_show', compact('joueur'));
    }

    public function index()
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        // Par défaut, saison active
        $saison_id = request('saison_id');
        $activeSaison = \App\Helpers\SaisonHelper::getActiveSaison();
        if ($saison_id === null || $saison_id === '') {
            $saison_id = $activeSaison?->id;
        }
        $saison = ($saison_id && $saison_id !== 'all') ? \App\Models\Saison::find($saison_id) : null;
        // Si "Toutes les saisons" => toutes les équipes, sinon équipes de la saison
        if ($saison_id === 'all') {
            $equipes = \App\Models\Equipe::orderBy('nom')->get();
        } else {
            $equipes = $saison ? \App\Models\Equipe::where('saison_id', $saison->id)->orderBy('nom')->get() : collect();
        }
        $clubSelected = null;
        $query = \App\Models\Joueur::with(['equipe', 'buts', 'cartons', 'saison', 'statsSaison']);
        // Filtre équipe
        if (request()->filled('equipe_id')) {
            if (request('equipe_id') === 'libre') {
                $query->whereNull('equipe_id');
            } else {
                $clubSelected = \App\Models\Equipe::find(request('equipe_id'));
                $query->where('equipe_id', request('equipe_id'));
            }
        }
        // Filtre saison
        if ($saison_id && $saison_id !== 'all') {
            $query->where('saison_id', $saison?->id);
        }
        // Recherche nom/prénom
        if (request()->filled('nom')) {
            $query->where(function($q) {
                $q->where('nom', 'like', '%' . request('nom') . '%')
                  ->orWhere('prenom', 'like', '%' . request('nom') . '%');
            });
        }
        $joueurs = $query->get();
        // Calcul score performance (exemple: buts*3 + mvp*2 - cartons_rouges*2 - cartons_jaunes)
        foreach ($joueurs as $joueur) {
            $stats = $joueur->statsSaison ? $joueur->statsSaison : $joueur->statsSaison();
            $buts = $stats?->buts ?? 0;
            $mvp = $stats?->mvp ?? 0;
            $jaunes = $stats?->cartons_jaunes ?? 0;
            $rouges = $stats?->cartons_rouges ?? 0;
            $joueur->perf_score = ($buts * 3) + ($mvp * 2) - ($rouges * 2) - $jaunes;
        }
        $joueurs = $joueurs->sortByDesc('perf_score');
        $groupedJoueurs = $joueurs->groupBy(function($joueur) {
            return $joueur->poste ?? 'Autres';
        });
        return view('public.joueurs', compact('equipes', 'groupedJoueurs', 'clubSelected', 'saisons', 'saison', 'saison_id', 'activeSaison'));
    }
}
