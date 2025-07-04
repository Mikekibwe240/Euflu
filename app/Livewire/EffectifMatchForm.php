<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Rencontre;
use App\Models\Equipe;
use App\Models\Joueur;
use App\Models\MatchEffectif;
use App\Models\MatchEffectifJoueur;
use App\Models\MatchRemplacement;

class EffectifMatchForm extends Component
{
    public Rencontre $match;
    public Equipe $equipe;
    public $joueurs = [];
    public $titulaires = [];
    public $remplacants = [];
    public $remplacements = [];

    public function mount($matchId, $equipeId)
    {
        $this->match = Rencontre::findOrFail($matchId);
        $this->equipe = Equipe::findOrFail($equipeId);
        $this->joueurs = $this->equipe->joueurs()->orderBy('nom')->get();
        // Pré-remplissage effectif existant
        $effectif = \App\Models\MatchEffectif::where('rencontre_id', $this->match->id)
            ->where('equipe_id', $this->equipe->id)
            ->with(['joueurs', 'remplacements'])
            ->first();
        if ($effectif) {
            $this->titulaires = $effectif->joueurs->where('type', 'titulaire')->pluck('joueur_id')->toArray();
            $this->remplacants = $effectif->joueurs->where('type', 'remplaçant')->pluck('joueur_id')->toArray();
            foreach ($effectif->remplacements as $remp) {
                $this->remplacements[$remp->joueur_remplacant_id] = [
                    'joueur' => $remp->joueur_remplace_id,
                    'minute' => $remp->minute,
                ];
            }
        }
    }

    public function updatedTitulaires()
    {
        $this->titulaires = array_slice(array_unique($this->titulaires), 0, 11);
    }

    public function updatedRemplacants()
    {
        $this->remplacants = array_slice(array_unique($this->remplacants), 0, 5);
    }

    public function save()
    {
        $this->validate([
            'titulaires' => 'required|array|size:11',
            'remplacants' => 'array|max:5',
            'remplacements' => 'array',
            'remplacements.*.joueur' => 'required_with:remplacements.*.minute|nullable|integer|exists:joueurs,id',
            'remplacements.*.minute' => 'required_with:remplacements.*.joueur|nullable|integer|min:1|max:120',
        ], [
            'titulaires.required' => 'Vous devez sélectionner 11 titulaires.',
            'titulaires.size' => 'Vous devez sélectionner exactement 11 titulaires.',
            'remplacants.max' => 'Vous pouvez sélectionner au maximum 5 remplaçants.',
            'remplacements.*.joueur.required_with' => 'Veuillez choisir le joueur remplacé.',
            'remplacements.*.minute.required_with' => 'La minute du remplacement est obligatoire.',
            'remplacements.*.minute.min' => 'La minute doit être comprise entre 1 et 120.',
            'remplacements.*.minute.max' => 'La minute doit être comprise entre 1 et 120.'
        ]);
        // Empêcher doublons
        if (count(array_intersect($this->titulaires, $this->remplacants)) > 0) {
            $this->addError('remplacants', 'Un joueur ne peut pas être titulaire et remplaçant.');
            return;
        }
        // Créer ou MAJ l'effectif
        $effectif = MatchEffectif::firstOrCreate([
            'rencontre_id' => $this->match->id,
            'equipe_id' => $this->equipe->id,
        ]);
        // Supprimer anciens effectifs/remplacements
        $effectif->joueurs()->delete();
        $effectif->remplacements()->delete();
        // Enregistrer titulaires
        foreach ($this->titulaires as $i => $joueurId) {
            MatchEffectifJoueur::create([
                'match_effectif_id' => $effectif->id,
                'joueur_id' => $joueurId,
                'type' => 'titulaire',
                'ordre' => $i+1,
            ]);
        }
        // Enregistrer remplaçants
        foreach ($this->remplacants as $i => $joueurId) {
            MatchEffectifJoueur::create([
                'match_effectif_id' => $effectif->id,
                'joueur_id' => $joueurId,
                'type' => 'remplaçant',
                'ordre' => $i+1,
            ]);
        }
        // Enregistrer remplacements
        foreach ($this->remplacements as $remplacantId => $data) {
            $remplaceId = $data['joueur'] ?? null;
            $minute = $data['minute'] ?? null;
            if ($remplacantId && $remplaceId && $minute) {
                MatchRemplacement::create([
                    'match_effectif_id' => $effectif->id,
                    'joueur_remplacant_id' => $remplacantId,
                    'joueur_remplace_id' => $remplaceId,
                    'minute' => $minute,
                ]);
            }
        }
        session()->flash('success', 'Effectif enregistré avec succès.');
    }

    public function render()
    {
        return view('livewire.effectif-match-form', [
            'joueurs' => $this->joueurs,
        ]);
    }
}
