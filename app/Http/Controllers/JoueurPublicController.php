<?php
namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\StatistiqueJoueur;
use Illuminate\Http\Request;
use App\Helpers\SaisonHelper;

class JoueurPublicController extends Controller
{
    public function show($id, Request $request)
    {
        $joueur = Joueur::with(['equipe', 'saison', 'transferts.fromEquipe', 'transferts.toEquipe'])->findOrFail($id);
        $saison = SaisonHelper::getActiveSaison($request);
        $stats = $joueur->statsSaison($saison?->id)->first();
        $buts = $joueur->buts()->with('rencontre')->whereHas('rencontre', function($q) use ($saison) {
            $q->where('saison_id', $saison?->id);
        })->get();
        $cartons = $joueur->cartons()->with('rencontre')->whereHas('rencontre', function($q) use ($saison) {
            $q->where('saison_id', $saison?->id);
        })->get();
        $mvps = $stats?->mvp ?? 0;
        return view('public.joueur.show', compact('joueur', 'stats', 'buts', 'cartons', 'mvps', 'saison'));
    }
}
