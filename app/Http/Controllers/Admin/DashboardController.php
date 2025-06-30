<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Saison;
use App\Models\Equipe;
use App\Models\Joueur;
use App\Models\Pool;
use App\Models\User;
use App\Models\Article;
use App\Models\Rencontre;
use App\Models\But;
use App\Models\Carton;

class DashboardController extends Controller
{
    public function index()
    {
        $saisonsActives = Saison::where('active', 1)->count();
        $equipes = Equipe::count();
        $joueurs = Joueur::count();
        $users = User::count();
        $articles = Article::count();
        $matchs = Rencontre::count();
        $buts = But::count();
        $cartons = Carton::count();
        $poules = Pool::with(['equipes', 'equipes.statsSaison'])->get();
        // Pour chaque poule, on prépare le classement comme dans la page publique
        foreach ($poules as $poule) {
            $classement = $poule->equipes->map(function($eq) {
                $stats = $eq->statsSaison()->first();
                return (object) [
                    'equipe' => $eq,
                    'mj' => $stats?->mj ?? 0,
                    'mg' => $stats?->victoires ?? 0,
                    'mp' => $stats?->defaites ?? 0,
                    'mn' => $stats?->nuls ?? 0,
                    'bp' => $stats?->buts_pour ?? 0,
                    'bc' => $stats?->buts_contre ?? 0,
                    'gd' => ($stats?->buts_pour ?? 0) - ($stats?->buts_contre ?? 0),
                    'points' => $stats?->points ?? 0,
                    'qualifie' => $stats?->qualifie ?? false,
                    'relegue' => $stats?->relegue ?? false,
                ];
            })->sortByDesc('points')->values();
            $poule->classement = $classement;
        }
        // Évolution joueurs/équipes par rapport aux matchs joués
        $matchsJoues = Rencontre::whereNotNull('score_equipe1')->whereNotNull('score_equipe2')->orderBy('date')->get();
        $evolutionLabels = [];
        $evolutionJoueurs = [];
        $evolutionEquipes = [];
        $datesVues = [];
        foreach ($matchsJoues as $match) {
            if ($match->date) {
                // Si déjà Carbon, on garde, sinon on convertit
                $dateObj = $match->date instanceof \Carbon\Carbon ? $match->date : \Carbon\Carbon::parse($match->date);
                $date = $dateObj->format('Y-m-d');
            } else {
                $date = $match->created_at->format('Y-m-d');
            }
            if (!in_array($date, $datesVues)) {
                $datesVues[] = $date;
                $evolutionLabels[] = $date;
                // Nombre de joueurs/équipes à cette date
                $nbJoueurs = Joueur::whereDate('created_at', '<=', $date)->count();
                $nbEquipes = Equipe::whereDate('created_at', '<=', $date)->count();
                $evolutionJoueurs[] = $nbJoueurs;
                $evolutionEquipes[] = $nbEquipes;
            }
        }
        // Si aucun match joué, fallback sur les totaux actuels
        if (empty($evolutionLabels)) {
            $evolutionLabels[] = now()->format('Y-m-d');
            $evolutionJoueurs[] = Joueur::count();
            $evolutionEquipes[] = Equipe::count();
        }
        return view('admin.dashboard', compact('saisonsActives', 'equipes', 'joueurs', 'users', 'articles', 'matchs', 'buts', 'cartons', 'poules', 'evolutionLabels', 'evolutionJoueurs', 'evolutionEquipes'));
    }
}
