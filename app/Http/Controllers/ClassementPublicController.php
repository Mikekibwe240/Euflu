<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\SaisonHelper;

class ClassementPublicController extends Controller
{
    public function index(Request $request)
    {
        $saison = SaisonHelper::getActiveSaison($request);
        $selectedPoule = $request->input('poule');
        $poules = $saison ? $saison->pools()->with(['equipes', 'equipes.statsSaison'])->get() : collect();
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        return view('public.classement', compact('saison', 'poules', 'selectedPoule', 'saisons'));
    }
}
