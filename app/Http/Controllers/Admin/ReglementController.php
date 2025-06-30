<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reglement;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReglementController extends Controller
{
    public function exportPdf(Request $request)
    {
        $query = Reglement::with('saison');
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
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
        $pdf = Pdf::loadView('exports.reglements_pdf', ['reglements' => $reglements]);
        return $pdf->download('reglements.pdf');
    }
}
