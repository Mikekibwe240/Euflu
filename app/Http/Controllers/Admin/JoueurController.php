<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Equipe;
use App\Models\Saison;
use Illuminate\Http\Request;
use App\Exports\JoueursExport;
use App\Exports\JoueursParEquipeExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class JoueurController extends Controller
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

        // Charger les équipes de la saison sélectionnée (ou vide si aucune)
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        $saisons = Saison::orderByDesc('date_debut')->get();

        // Construire la requête filtrée
        $query = Joueur::with('equipe');
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('equipe_id')) {
            if ($request->equipe_id === 'libre') {
                $query->whereNull('equipe_id');
            } else {
                $query->where('equipe_id', $request->equipe_id);
            }
        }
        if ($saison) {
            $query->where('saison_id', $saison->id);
        }
        $joueurs = $query->paginate(20)->withQueryString();

        return view('admin.joueurs.index', compact('joueurs', 'saison', 'equipes', 'saisons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        $equipe_id = $request->input('equipe_id');
        return view('admin.joueurs.create', compact('equipes', 'saison', 'equipe_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $messages = [
            'nom.required' => 'Le nom du joueur est obligatoire.',
            'prenom.required' => 'Le prénom du joueur est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'poste.required' => 'Le poste du joueur est obligatoire.',
            'equipe_id.exists' => 'L’équipe sélectionnée n’existe pas.',
            'photo.image' => 'La photo doit être une image.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ];
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'poste' => 'required|string|max:100',
            'equipe_id' => 'nullable|exists:equipes,id', // équipe optionnelle
            'photo' => 'nullable|image|max:2048',
        ], $messages);
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $data = $request->only(['nom', 'prenom', 'date_naissance', 'poste', 'equipe_id']);
        $data['saison_id'] = $saison?->id;
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('joueurs', 'public');
        }
        Joueur::create($data);
        Log::info('Création d\'un joueur', ['nom' => $data['nom'], 'prenom' => $data['prenom'], 'admin_id' => Auth::id()]);
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $joueur = \App\Models\Joueur::with(['equipe', 'buts', 'transferts.fromEquipe', 'transferts.toEquipe'])->findOrFail($id);
        $saison = \App\Models\Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $equipes = $saison ? \App\Models\Equipe::where('saison_id', $saison->id)->get() : collect();
        return view('admin.joueurs.show', compact('joueur', 'equipes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $joueur = Joueur::findOrFail($id);
        $saison = Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first();
        $equipes = $saison ? Equipe::where('saison_id', $saison->id)->get() : collect();
        return view('admin.joueurs.edit', compact('joueur', 'equipes', 'saison'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $joueur = Joueur::findOrFail($id);
        $messages = [
            'nom.required' => 'Le nom du joueur est obligatoire.',
            'prenom.required' => 'Le prénom du joueur est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'poste.required' => 'Le poste du joueur est obligatoire.',
            'equipe_id.exists' => 'L’équipe sélectionnée n’existe pas.',
            'photo.image' => 'La photo doit être une image.',
            'photo.max' => 'La photo ne doit pas dépasser 2 Mo.',
        ];
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'poste' => 'required|string|max:100',
            'equipe_id' => 'nullable|exists:equipes,id', // équipe optionnelle
            'photo' => 'nullable|image|max:2048',
        ], $messages);
        $data = $request->only(['nom', 'prenom', 'date_naissance', 'poste', 'equipe_id']);
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('joueurs', 'public');
        }
        $joueur->update($data);
        Log::info('Modification d\'un joueur', ['joueur_id' => $joueur->id, 'admin_id' => Auth::id()]);
        return redirect()->route('admin.joueurs.index')->with('success', 'Joueur modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $joueur = Joueur::findOrFail($id);
        $nom = $joueur->nom . ' ' . $joueur->prenom;
        if ($request->input('action') === 'libre') {
            $joueur->equipe_id = null;
            $joueur->save();
            Log::info('Joueur rendu libre', ['joueur' => $nom, 'admin_id' => Auth::id()]);
            return redirect()->route('admin.joueurs.index')->with('success', "Le joueur $nom est maintenant libre (sans équipe).");
        } else {
            $joueur->delete();
            Log::info('Suppression du joueur', ['joueur' => $nom, 'admin_id' => Auth::id()]);
            return redirect()->route('admin.joueurs.index')->with('success', "Le joueur $nom a bien été supprimé de la base de données.");
        }
    }

    /**
     * Export the filtered players to an Excel file.
     */
    public function export(Request $request)
    {
        $query = Equipe::with(['joueurs' => function($q) use ($request) {
            if ($request->filled('nom')) {
                $q->where('nom', 'like', '%' . $request->nom . '%');
            }
            if ($request->filled('saison_id')) {
                $q->where('saison_id', $request->saison_id);
            }
        }]);
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        $equipes = $query->orderBy('nom')->get();
        return Excel::download(new JoueursParEquipeExport($equipes), 'joueurs.xlsx');
    }

    /**
     * Export the filtered players to a PDF file.
     */
    public function exportPdf(Request $request)
    {
        $query = Joueur::with('equipe');
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        if ($request->filled('equipe_id')) {
            if ($request->equipe_id === 'libre') {
                $query->whereNull('equipe_id');
            } else {
                $query->where('equipe_id', $request->equipe_id);
            }
        }
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        $joueurs = $query->orderBy('nom')->get();
        $pdf = Pdf::loadView('exports.joueurs_pdf', ['joueurs' => $joueurs]);
        return $pdf->download('joueurs.pdf');
    }

    /**
     * Affecter une équipe à un joueur libre
     */
    public function affecterEquipe(Request $request, $id)
    {
        $joueur = Joueur::findOrFail($id);
        if ($joueur->equipe_id) {
            return redirect()->route('admin.joueurs.show', $joueur)->with('error', 'Ce joueur appartient déjà à une équipe.');
        }
        $request->validate([
            'equipe_id' => 'required|exists:equipes,id',
        ]);
        $joueur->equipe_id = $request->equipe_id;
        $joueur->save();
        Log::info('Affectation d\'une équipe à un joueur libre', ['joueur_id' => $joueur->id, 'equipe_id' => $request->equipe_id, 'admin_id' => Auth::id()]);
        return redirect()->route('admin.joueurs.show', $joueur)->with('success', 'Le joueur a été affecté à l\'équipe avec succès.');
    }
}
