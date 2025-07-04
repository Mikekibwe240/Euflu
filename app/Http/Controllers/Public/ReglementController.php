<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Reglement;
use Illuminate\Http\Request;

class ReglementController extends Controller
{
    /**
     * Display a listing of the regulations.
     */
    public function index(Request $request)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $saison = null;
        if ($request->filled('saison_id')) {
            $saison = \App\Models\Saison::find($request->saison_id);
        } else {
            $saison = \App\Models\Saison::where('active', 1)->first();
        }
        $query = Reglement::with(['saison', 'user']);
        if ($saison) {
            $query->where('saison_id', $saison->id);
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
        return view('public.reglements', compact('reglements', 'saisons', 'saison'));
    }

    /**
     * Display the specified regulation.
     */
    public function show($id)
    {
        $reglement = \App\Models\Reglement::with(['saison', 'user'])->findOrFail($id);
        return view('public.reglement_show', compact('reglement'));
    }
}
