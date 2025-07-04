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
}
