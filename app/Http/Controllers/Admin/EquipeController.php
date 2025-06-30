<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EquipesExport;
use App\Http\Controllers\Controller;
use App\Models\Equipe;
use App\Models\Pool;
use App\Models\Saison;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Déterminer la saison sélectionnée ou la saison ouverte par défaut
        if ($request->filled('saison_id')) {
            $saison = Saison::find($request->saison_id);
        } else {
            $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        }

        // Charger les pools de la saison sélectionnée (ou vide si aucune)
        $pools = $saison ? Pool::where('saison_id', $saison->id)->get() : collect();
        $saisons = Saison::orderByDesc('date_debut')->get();

        // Construire la requête filtrée
        $query = Equipe::with('pool');
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('pool_id')) {
            if ($request->pool_id === 'libre') {
                $query->whereNull('pool_id');
            } else {
                $query->where('pool_id', $request->pool_id);
            }
        }
        if ($saison) {
            $query->where('saison_id', $saison->id);
        }
        $equipes = $query->paginate(20)->withQueryString();

        return view('admin.equipes.index', compact('equipes', 'saison', 'pools', 'saisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        // S'assurer que les pools A et B existent pour la saison active
        if ($saison) {
            if (!Pool::where('saison_id', $saison->id)->where('nom', 'A')->exists()) {
                Pool::create(['nom' => 'A', 'saison_id' => $saison->id]);
            }
            if (!Pool::where('saison_id', $saison->id)->where('nom', 'B')->exists()) {
                Pool::create(['nom' => 'B', 'saison_id' => $saison->id]);
            }
        }
        $pools = Pool::where('saison_id', $saison?->id)->get();
        return view('admin.equipes.create', compact('pools', 'saison'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $messages = [
            'nom.required' => 'Le nom de l’équipe est obligatoire.',
            'nom.unique' => 'Ce nom d’équipe existe déjà pour cette saison.',
            // Suppression du message pool_id.required
            'pool_id.exists' => 'Le pool sélectionné n’existe pas.',
            'coach.required' => 'Le nom du coach est obligatoire.',
            'coach.min' => 'Le nom du coach doit comporter au moins 2 caractères.',
            'logo.image' => 'Le logo doit être une image.',
            'logo.max' => 'Le logo ne doit pas dépasser 2 Mo.',
        ];
        $request->validate([
            'nom' => 'required|unique:equipes,nom,NULL,id,saison_id,' . $saison?->id,
            'pool_id' => 'nullable|exists:pools,id',
            'coach' => 'required|min:2',
            'logo' => 'nullable|image|max:2048',
        ], $messages);
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }
        Equipe::create([
            'nom' => $request->nom,
            'pool_id' => $request->pool_id,
            'saison_id' => $saison?->id,
            'coach' => $request->coach,
            'logo' => $logoPath,
        ]);
        \Log::info('Création d\'une équipe', ['nom' => $request->nom, 'admin_id' => auth()->id()]);
        return redirect()->route('admin.equipes.index')->with('success', 'Équipe ajoutée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $equipe = Equipe::with(['pool', 'saison', 'joueurs.buts', 'statsSaisons'])->findOrFail($id);
        $rencontres = \App\Models\Rencontre::with(['equipe1', 'equipe2'])
            ->where(function($q) use($id) {
                $q->where('equipe1_id', $id)->orWhere('equipe2_id', $id);
            })
            ->orderBy('date')
            ->get();
        return view('admin.equipes.show', compact('equipe', 'rencontres'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipe $equipe)
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $pools = Pool::where('saison_id', $saison?->id)->get();
        return view('admin.equipes.edit', compact('equipe', 'pools', 'saison'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipe $equipe)
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $messages = [
            'nom.required' => 'Le nom de l’équipe est obligatoire.',
            'nom.unique' => 'Ce nom d’équipe existe déjà pour cette saison.',
            'pool_id.required' => 'Le pool est obligatoire.',
            'pool_id.exists' => 'Le pool sélectionné n’existe pas.',
            'coach.required' => 'Le nom du coach est obligatoire.',
            'coach.min' => 'Le nom du coach doit comporter au moins 2 caractères.',
            'logo.image' => 'Le logo doit être une image.',
            'logo.max' => 'Le logo ne doit pas dépasser 2 Mo.',
        ];
        $request->validate([
            'nom' => 'required|unique:equipes,nom,' . $equipe->id . ',id,saison_id,' . $saison?->id,
            'pool_id' => 'required|exists:pools,id',
            'coach' => 'required|min:2',
            'logo' => 'nullable|image|max:2048',
        ], $messages);
        $logoPath = $equipe->logo;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }
        $equipe->update([
            'nom' => $request->nom,
            'pool_id' => $request->pool_id,
            'coach' => $request->coach,
            'logo' => $logoPath,
        ]);
        \Log::info('Modification d\'une équipe', ['equipe_id' => $equipe->id, 'admin_id' => auth()->id()]);
        return redirect()->route('admin.equipes.index')->with('success', 'Équipe modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipe $equipe)
    {
        $nom = $equipe->nom;
        $equipe->delete();
        \Log::info('Suppression d\'une équipe', ['equipe' => $nom, 'admin_id' => auth()->id()]);
        return redirect()->route('admin.equipes.index')->with('success', "L’équipe $nom a bien été retirée.");
    }

    /**
     * Export the filtered equipes to an Excel file.
     */
    public function export(Request $request)
    {
        $query = Equipe::with(['pool', 'saison']);
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('pool_id')) {
            $query->where('pool_id', $request->pool_id);
        }
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        $equipes = $query->orderBy('nom')->get();
        return Excel::download(new EquipesExport($equipes), 'equipes.xlsx');
    }

    /**
     * Export the filtered equipes to a PDF file.
     */
    public function exportPdf(Request $request)
    {
        $query = Equipe::with(['pool', 'saison']);
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('pool_id')) {
            $query->where('pool_id', $request->pool_id);
        }
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        $equipes = $query->orderBy('nom')->get();
        $pdf = Pdf::loadView('exports.equipes_pdf', ['equipes' => $equipes]);
        return $pdf->download('equipes.pdf');
    }

    /**
     * Affecter un joueur libre à cette équipe
     */
    public function affecterJoueur(Request $request, $equipeId)
    {
        $equipe = \App\Models\Equipe::findOrFail($equipeId);
        $request->validate([
            'joueur_id' => 'required|exists:joueurs,id',
        ]);
        $joueur = \App\Models\Joueur::whereNull('equipe_id')->findOrFail($request->joueur_id);
        $joueur->equipe_id = $equipe->id;
        $joueur->save();
        \Log::info('Affectation rapide d\'un joueur libre à une équipe', ['joueur_id' => $joueur->id, 'equipe_id' => $equipe->id, 'admin_id' => auth()->id()]);
        return redirect()->route('admin.equipes.show', $equipe)->with('success', 'Joueur ajouté à l\'équipe avec succès.');
    }
}
