<?php

namespace App\Http\Controllers;

use App\Models\Reglement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\SaisonHelper;

class ReglementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $saison = null;
        $query = Reglement::with(['saison', 'user', 'updatedBy']);
        // Correction stricte :
        // - Si saison_id == 'all' ou non présent, ne pas filtrer (toutes saisons)
        // - Si saison_id == '' (Actuelle), filtrer UNIQUEMENT sur la saison active
        // - Sinon, filtrer sur la saison choisie
        if ($request->filled('saison_id') && $request->saison_id !== 'all') {
            if ($request->saison_id === '') {
                $saison = \App\Models\Saison::where('active', 1)->first();
                if ($saison) {
                    $query->where('saison_id', $saison->id);
                }
            } else {
                $saison = \App\Models\Saison::find($request->saison_id);
                if ($saison) {
                    $query->where('saison_id', $saison->id);
                }
            }
        }
        if ($request->filled('titre')) {
            $query->where('titre', 'like', '%' . $request->titre . '%');
        }
        if ($request->filled('auteur')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->auteur . '%');
            });
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('titre', 'like', "%$q%")
                     ->orWhere('contenu', 'like', "%$q%")
                     ->orWhereHas('user', function($u) use ($q) {
                         $u->where('name', 'like', "%$q%") ;
                     });
            });
        }
        $reglements = $query->orderByDesc('created_at')->paginate(10);
        return view('admin.reglements.index', compact('reglements', 'saisons', 'saison'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        return view('admin.reglements.create', compact('saisons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);
        // Find active season, fallback to 2024-2025 if not found
        $activeSaison = \App\Models\Saison::where('active', 1)->first();
        if (!$activeSaison) {
            $activeSaison = \App\Models\Saison::where('nom', '2024-2025')->first();
        }
        $data = $request->only(['titre', 'contenu']);
        $data['user_id'] = Auth::id();
        $data['saison_id'] = $activeSaison ? $activeSaison->id : null;
        $reglement = Reglement::create($data);
        return redirect()->route('admin.reglements.index')->with('success', 'Règlement ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reglement $reglement)
    {
        $reglement->load(['saison', 'user', 'updatedBy']);
        return view('admin.reglements.show', compact('reglement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reglement $reglement)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        return view('admin.reglements.edit', compact('reglement', 'saisons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reglement $reglement)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
        ]);
        // Find active season, fallback to 2024-2025 if not found
        $activeSaison = \App\Models\Saison::where('active', 1)->first();
        if (!$activeSaison) {
            $activeSaison = \App\Models\Saison::where('nom', '2024-2025')->first();
        }
        $data = $request->only(['titre', 'contenu']);
        $data['updated_by'] = Auth::id();
        $data['saison_id'] = $activeSaison ? $activeSaison->id : null;
        $reglement->update($data);
        return redirect()->route('admin.reglements.index')->with('success', 'Règlement modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reglement $reglement)
    {
        $reglement->delete();
        return redirect()->route('admin.reglements.index')->with('success', 'Règlement supprimé avec succès.');
    }
}
