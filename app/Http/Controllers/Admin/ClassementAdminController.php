<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Saison;
use App\Models\Pool;

class ClassementAdminController extends Controller
{
    public function index(Request $request)
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        $selectedSaison = $request->input('saison_id') ? Saison::find($request->input('saison_id')) : Saison::where('active', 1)->first();
        $pools = $selectedSaison ? $selectedSaison->pools()->with(['equipes', 'equipes.statsSaison'])->get() : collect();
        $selectedPool = $request->input('pool');
        if ($selectedPool) {
            $pools = $pools->filter(fn($pool) => $pool->nom == $selectedPool);
        }
        return view('admin.classement', compact('saisons', 'selectedSaison', 'pools', 'selectedPool'));
    }
}
