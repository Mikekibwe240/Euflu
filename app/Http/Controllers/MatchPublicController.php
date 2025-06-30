<?php
namespace App\Http\Controllers;

use App\Models\Rencontre;
use Illuminate\Http\Request;

class MatchPublicController extends Controller
{
    public function show($id)
    {
        $rencontre = Rencontre::with([
            'equipe1.joueurs', 'equipe2.joueurs', 'buts.joueur', 'cartons.joueur', 'mvp'
        ])->findOrFail($id);
        return view('public.match.show', compact('rencontre'));
    }

    public function index(Request $request)
    {
        $query = \App\Models\Rencontre::with(['equipe1', 'equipe2', 'pool', 'buts', 'cartons']);
        if ($request->filled('pool_id')) {
            if ($request->pool_id === 'AMICAL') {
                $query->where(function($q) {
                    $q->where('type_rencontre', 'amical')
                      ->orWhere('type_rencontre', 'externe');
                });
            } else {
                $pool = \App\Models\Pool::whereRaw('LOWER(nom) = ?', [strtolower($request->pool_id)])->first();
                if ($pool) {
                    $query->where('pool_id', $pool->id);
                } else {
                    // Aucun pool trouvé, retourner aucun résultat
                    $query->whereRaw('1=0');
                }
            }
        }
        if ($request->filled('equipe_id')) {
            $query->where(function($q) use ($request) {
                $q->where('equipe1_id', $request->equipe_id)
                  ->orWhere('equipe2_id', $request->equipe_id);
            });
        }
        if ($request->filled('journee')) {
            $query->where('journee', $request->journee);
        }
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        if ($request->filled('type')) {
            $query->where('type_rencontre', $request->type);
        }
        // Statut filter
        if ($request->filled('statut')) {
            if ($request->statut === 'joue') {
                $query->whereNotNull('score_equipe1')->whereNotNull('score_equipe2');
            } elseif ($request->statut === 'non joue') {
                $query->where(function($q) {
                    $q->whereNull('score_equipe1')->orWhereNull('score_equipe2');
                });
            }
        }
        $rencontres = $query->orderBy('date')->get();
        $pools = \App\Models\Pool::all();
        $equipes = \App\Models\Equipe::all();
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        // Types et statuts pour les filtres
        $types = \App\Models\Rencontre::distinct()->pluck('type_rencontre')->filter()->values();
        $statuts = collect(['joue', 'non joue']);
        // Widgets stats
        $all = $query->get();
        $total = $all->count();
        $joues = $all->whereNotNull('score_equipe1')->whereNotNull('score_equipe2')->count();
        $avenir = $total - $joues;
        $buts = $all->flatMap->buts->count();
        $cartons = $all->flatMap->cartons->count();
        return view('public.matchs', compact('rencontres', 'pools', 'equipes', 'saisons', 'total', 'joues', 'avenir', 'buts', 'cartons', 'types', 'statuts'));
    }
    public function pdf($id)
    {
        $rencontre = \App\Models\Rencontre::with(['equipe1', 'equipe2', 'buts.joueur', 'cartons.joueur', 'mvp', 'pool'])
            ->findOrFail($id);
        $pdf = \PDF::loadView('public.match.pdf', compact('rencontre'));
        return $pdf->download('feuille_match_'.$rencontre->id.'.pdf');
    }
}
