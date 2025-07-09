<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reglement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\SaisonHelper;

class ReglementController extends Controller
{
    public function exportPdf(Request $request)
    {
        $saison = \App\Models\Saison::where('active', 1)->first();
        $query = Reglement::with('saison');
        if ($saison) {
            $query->where('saison_id', $saison->id);
        }
        if ($request->filled('titre')) {
            $query->where('titre', 'like', '%' . $request->titre . '%');
        }
        if ($request->filled('auteur')) {
            $query->where('auteur', 'like', '%' . $request->auteur . '%');
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('titre', 'like', "%$q%")
                     ->orWhere('description', 'like', "%$q%")
                     ->orWhere('auteur', 'like', "%$q%") ;
            });
        }
        $reglements = $query->orderByDesc('created_at')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.reglements_pdf', ['reglements' => $reglements]);
        return $pdf->download('reglements.pdf');
    }

    public function index(Request $request)
    {
        $saisons = \App\Models\Saison::orderByDesc('date_debut')->get();
        $saison = null;
        // Si aucun paramètre saison_id n'est passé, on force 'all' (Toutes)
        $params = $request->all();
        if (!array_key_exists('saison_id', $params)) {
            $request->merge(['saison_id' => 'all']);
        }
        $query = Reglement::with(['saison', 'user', 'updatedBy']);
        // Logique stricte :
        // - Si saison_id == 'all' ou non présent, ne pas filtrer (toutes saisons)
        // - Si saison_id == '' (Actuelle), filtrer UNIQUEMENT sur la saison active
        // - Sinon, filtrer sur la saison choisie
        if ($request->filled('saison_id') && $request->saison_id !== 'all') {
            if ($request->saison_id === '') {
                $saison = \App\Models\Saison::where('active', 1)->first();
                if ($saison) {
                    $query->where('saison_id', $saison->id);
                } else {
                    // Aucune saison active : on force à aucun résultat
                    $query->whereRaw('1=0');
                }
            } else {
                $saison = \App\Models\Saison::find($request->saison_id);
                if ($saison) {
                    $query->where('saison_id', $saison->id);
                } else {
                    $query->whereRaw('1=0');
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
}
