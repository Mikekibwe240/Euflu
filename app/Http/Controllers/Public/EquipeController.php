<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use Illuminate\Http\Request;
use App\Models\Saison;
use App\Helpers\SaisonHelper;

class EquipeController extends Controller
{
    public function index(Request $request)
    {
        $saison = SaisonHelper::getActiveSaison($request);
        $query = \App\Models\Equipe::with('pool');
        if ($saison) {
            $query->where('saison_id', $saison->id);
        }
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
        $pools = $saison ? $saison->pools()->with('equipes')->get() : collect();
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        if (!isset($saisons)) $saisons = collect();
        return view('public.equipes', compact('equipes', 'pools', 'saison', 'saisons'));
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
        $saison = Saison::where('active', 1)->first();
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
        $rencontres = $equipe->rencontres()->where('saison_id', $saison?->id)->orderBy('date')->get();
        $stats = $equipe->statsSaison($saison?->id)->first();
        return view('public.equipe_show', compact('equipe', 'classement', 'position', 'rencontres', 'stats', 'saison'));
    }
}
