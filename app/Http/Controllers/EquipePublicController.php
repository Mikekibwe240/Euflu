<?php
namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\StatistiqueEquipe;
use App\Models\Rencontre;
use Illuminate\Http\Request;

class EquipePublicController extends Controller
{
    public function show($id)
    {
        $equipe = \App\Models\Equipe::with(['joueurs.buts', 'pool.equipes', 'saison'])->findOrFail($id);
        $rencontres = \App\Models\Rencontre::with(['equipe1', 'equipe2'])
            ->where(function($q) use($id) {
                $q->where('equipe1_id', $id)->orWhere('equipe2_id', $id);
            })
            ->orderBy('date')
            ->get();
        $saison = $equipe->saison;
        $stats = $equipe->statsSaison($saison?->id)->first();
        $classement = $equipe->pool ? $equipe->pool->equipes->map(function($eq) use ($saison) {
            $stats = $eq->statsSaison($saison?->id)->first();
            return [
                'equipe' => $eq,
                'points' => $stats?->points ?? 0,
                'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                'bp' => $stats?->buts_pour ?? 0,
            ];
        })->sortByDesc('points')->sortByDesc('gd')->sortByDesc('bp')->values() : collect();
        $position = $classement->search(fn($row) => $row['equipe']->id == $equipe->id);
        $position = $position !== false && $position !== null ? $position + 1 : null;
        if (!isset($rencontres)) $rencontres = collect();
        return view('public.equipe_show', compact('equipe', 'rencontres', 'stats', 'position'));
    }
}
