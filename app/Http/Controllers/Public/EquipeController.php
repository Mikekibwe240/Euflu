<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Models\Saison;

class EquipeController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Equipe::with('pool');
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('pool_id')) {
            if ($request->pool_id === 'libre') {
                $query->whereNull('pool_id');
            } else {
                $query->where('pool_id', $request->pool_id);
            }
        }
        $equipes = $query->orderBy('nom')->paginate(10);
        $pools = \App\Models\Pool::all();
        return view('public.equipes', compact('equipes', 'pools'));
    }

    public function search(Request $request)
    {
        $query = Equipe::with('pool');
        if ($request->filled('q')) {
            $query->where('nom', 'like', '%' . $request->q . '%');
        }
        $equipes = $query->orderBy('nom')->get();
        return view('public.equipes_search', compact('equipes'));
    }

    public function show($id)
    {
        $equipe = Equipe::with(['joueurs', 'pool', 'joueurs.buts'])->findOrFail($id);
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $poule = $equipe->pool;
        $classement = collect();
        if ($poule) {
            $classement = $poule->equipes->map(function($eq) use ($saison) {
                $stats = $eq->statsSaison($saison?->id)->first();
                return [
                    'equipe_id' => $eq->id,
                    'points' => $stats?->points ?? 0,
                    'victoires' => $stats?->victoires ?? 0,
                    'buts_pour' => $stats?->buts_pour ?? 0,
                    'buts_contre' => $stats?->buts_contre ?? 0,
                ];
            })->sortByDesc('points')->values();
        }
        $position = null;
        foreach ($classement as $idx => $row) {
            if ($row['equipe_id'] == $equipe->id) {
                $position = $idx + 1;
                break;
            }
        }
        // Récupérer stats équipe pour la saison
        $stats = $equipe->statsSaison ? $equipe->statsSaison($saison?->id)->first() : null;
        // Calcul dynamique si pas de stats
        if (!$stats) {
            $buts_pour = $equipe->joueurs->sum(fn($j) => $j->buts->count());
            $stats = (object)[
                'points' => '-',
                'victoires' => '-',
                'nuls' => '-',
                'defaites' => '-',
                'buts_pour' => $buts_pour,
                'buts_contre' => '-',
            ];
        }
        return view('public.equipe_show', compact('equipe', 'position', 'stats'));
    }
}
