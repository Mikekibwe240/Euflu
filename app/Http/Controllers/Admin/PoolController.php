<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pool;
use App\Models\Saison;
use Illuminate\Http\Request;

class PoolController extends Controller
{
    public function index(Request $request)
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        $query = Pool::with('saison');
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        $pools = $query->orderBy('nom')->get();
        return view('admin.pools.index', compact('pools', 'saisons'));
    }
}
