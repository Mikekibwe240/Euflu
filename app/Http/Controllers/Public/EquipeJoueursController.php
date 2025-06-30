<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Saison;

class EquipeJoueursController extends Controller
{
    public function index($id)
    {
        $equipe = Equipe::with('joueurs', 'pool')->findOrFail($id);
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
            // Optionally, add more tie-breakers here (victoires, goal average, etc.)
        }
        $position = null;
        foreach ($classement as $idx => $row) {
            if ($row['equipe_id'] == $equipe->id) {
                $position = $idx + 1;
                break;
            }
        }
        return view('public.equipe_joueurs', compact('equipe', 'position'));
    }
}
