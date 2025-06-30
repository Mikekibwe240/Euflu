<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pool;

class EquipesParPouleController extends Controller
{
    public function index()
    {
        $poules = Pool::with('equipes')->orderBy('nom')->get();
        return view('public.equipes_par_poule', compact('poules'));
    }
}
