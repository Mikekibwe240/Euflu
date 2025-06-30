<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Saison;
use Illuminate\Http\Request;

class SaisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $saisons = Saison::orderByDesc('date_debut')->get();
        return view('admin.saisons.index', compact('saisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        return view('admin.saisons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $messages = [
            'nom.required' => 'Le nom de la saison est obligatoire.',
            'nom.unique' => 'Ce nom de saison existe déjà.',
            'date_debut.required' => 'La date de début est obligatoire.',
            'date_debut.date' => 'La date de début doit être une date valide.',
            'date_fin.required' => 'La date de fin est obligatoire.',
            'date_fin.date' => 'La date de fin doit être une date valide.',
            'date_fin.after' => 'La date de fin doit être postérieure à la date de début.',
        ];
        $request->validate([
            'nom' => 'required|unique:saisons,nom',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
        ], $messages);
        Saison::create([
            'nom' => $request->nom,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'etat' => 'ouverte',
        ]);
        \Log::info('Création d\'une saison', ['nom' => $request->nom, 'admin_id' => auth()->id()]);
        return redirect()->route('admin.saisons.index')->with('success', 'Saison créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Close the specified season.
     */
    public function close(Saison $saison)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $saison->etat = 'cloturee';
        $saison->save();
        \Log::info('Clôture d\'une saison', ['saison_id' => $saison->id, 'admin_id' => auth()->id()]);
        return redirect()->route('admin.saisons.index')->with('success', 'Saison clôturée avec succès !');
    }

    /**
     * Activate the specified season.
     */
    public function activate(Saison $saison)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        // Désactive toutes les autres saisons
        Saison::where('id', '!=', $saison->id)->update(['active' => 0]);
        $saison->active = 1;
        $saison->save();
        return redirect()->route('admin.saisons.index')->with('success', 'Saison activée.');
    }

    /**
     * Deactivate the specified season.
     */
    public function deactivate(Saison $saison)
    {
        if (!auth()->user() || !auth()->user()->is_super_admin) {
            abort(403, 'Accès réservé au super admin');
        }
        $saison->active = 0;
        $saison->save();
        return redirect()->route('admin.saisons.index')->with('success', 'Saison désactivée.');
    }
}
