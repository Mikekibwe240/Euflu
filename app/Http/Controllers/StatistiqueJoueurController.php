<?php

namespace App\Http\Controllers;

use App\Models\StatistiqueJoueur;
use Illuminate\Http\Request;

class StatistiqueJoueurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $equipes = collect();
        if ($request->filled('saison_id')) {
            $equipes = \App\Models\Equipe::where('saison_id', $request->saison_id)->get();
        }
        $query = \App\Models\StatistiqueJoueur::with(['joueur.equipe']);
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        if ($request->filled('equipe_id')) {
            $query->whereHas('joueur', function($q) use ($request) {
                $q->where('equipe_id', $request->equipe_id);
            });
        }
        $stats = $query->get();
        return view('admin.statistiques_joueurs.index', compact('stats', 'saisons', 'equipes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StatistiqueJoueur $statistiqueJoueur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatistiqueJoueur $statistiqueJoueur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatistiqueJoueur $statistiqueJoueur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatistiqueJoueur $statistiqueJoueur)
    {
        //
    }
}
