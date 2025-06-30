<?php
namespace App\Http\Controllers;

use App\Models\Joueur;
use App\Models\StatistiqueJoueur;
use Illuminate\Http\Request;

class JoueurPublicController extends Controller
{
    public function show($id)
    {
        $joueur = Joueur::with(['equipe', 'saison', 'transferts.fromEquipe', 'transferts.toEquipe'])->findOrFail($id);
        $stats = StatistiqueJoueur::where('joueur_id', $id)->orderByDesc('saison_id')->first();
        $buts = $joueur->buts()->with('rencontre')->get();
        $cartons = $joueur->cartons()->with('rencontre')->get();
        $mvps = $joueur->statistiqueJoueur ? $joueur->statistiqueJoueur->mvp : 0;
        return view('public.joueur.show', compact('joueur', 'stats', 'buts', 'cartons', 'mvps'));
    }
}
