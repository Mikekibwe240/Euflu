<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Joueur;
use App\Models\Equipe;
use Illuminate\Http\Request;

class TransfertController extends Controller
{
    public function index()
    {
        $pools = \App\Models\Pool::with(['equipes.joueurs'])->get();
        $joueurs = Joueur::with('equipe')->orderBy('nom')->get();
        $equipes = Equipe::orderBy('nom')->get();
        // Préparer les tableaux JSON pour la vue (structure simple, pas de fonction anonyme fléchée)
        $joueurs_json = [];
        foreach ($joueurs as $j) {
            $joueurs_json[] = [
                'id' => $j->id,
                'nom' => $j->nom,
                'prenom' => $j->prenom,
                'photo' => $j->photo,
                'equipe' => $j->equipe ? ['nom' => $j->equipe->nom, 'logo' => $j->equipe->logo] : null
            ];
        }
        $equipes_json = [];
        foreach ($equipes as $e) {
            $equipes_json[] = [
                'id' => $e->id,
                'nom' => $e->nom,
                'logo' => $e->logo
            ];
        }
        return view('admin.transferts.index', compact('joueurs', 'equipes', 'pools', 'joueurs_json', 'equipes_json'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'joueur_id' => 'required|exists:joueurs,id',
            'equipe_id' => 'nullable|exists:equipes,id',
        ]);
        $joueur = Joueur::findOrFail($request->joueur_id);
        $fromEquipeId = $joueur->equipe_id;
        $toEquipeId = $request->equipe_id;
        $type = $toEquipeId ? ($fromEquipeId ? 'transfert' : 'affectation') : 'liberation';
        $joueur->equipe_id = $toEquipeId;
        $joueur->save();
        \App\Models\Transfert::create([
            'joueur_id' => $joueur->id,
            'from_equipe_id' => $fromEquipeId,
            'to_equipe_id' => $toEquipeId,
            'date' => now()->toDateString(),
            'type' => $type,
        ]);
        $msg = '';
        if ($type === 'liberation') {
            $msg = 'Le joueur ' . $joueur->nom . ' ' . $joueur->prenom . ' est maintenant libre (sans équipe).';
        } elseif ($type === 'transfert') {
            $from = $fromEquipeId ? (\App\Models\Equipe::find($fromEquipeId)?->nom ?? 'Inconnue') : 'Aucune';
            $to = $toEquipeId ? (\App\Models\Equipe::find($toEquipeId)?->nom ?? 'Inconnue') : 'Libre';
            $msg = 'Le joueur ' . $joueur->nom . ' ' . $joueur->prenom . ' a été transféré de ' . $from . ' à ' . $to . '.';
        } elseif ($type === 'affectation') {
            $to = $toEquipeId ? (\App\Models\Equipe::find($toEquipeId)?->nom ?? 'Inconnue') : 'Libre';
            $msg = 'Le joueur ' . $joueur->nom . ' ' . $joueur->prenom . ' a été affecté à l\'équipe ' . $to . '.';
        }
        return redirect()->route('admin.transferts.index')->with('success', $msg);
    }
}
