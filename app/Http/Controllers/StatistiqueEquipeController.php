<?php

namespace App\Http\Controllers;

use App\Models\StatistiqueEquipe;
use Illuminate\Http\Request;

class StatistiqueEquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $query = \App\Models\StatistiqueEquipe::with('equipe');
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        $stats = $query->get();
        return view('admin.statistiques_equipes.index', compact('stats', 'saisons'));
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
    public function show(StatistiqueEquipe $statistiqueEquipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StatistiqueEquipe $statistiqueEquipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StatistiqueEquipe $statistiqueEquipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StatistiqueEquipe $statistiqueEquipe)
    {
        //
    }
}
