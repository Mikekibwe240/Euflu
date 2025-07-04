<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joueur extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'prenom', 'date_naissance', 'poste', 'equipe_id', 'photo', 'saison_id', 'numero_licence', 'numero_dossard', 'nationalite'];

    public function equipe() { return $this->belongsTo(Equipe::class); }
    public function saison() { return $this->belongsTo(Saison::class); }
    public function buts() { return $this->hasMany(But::class); }
    public function cartons() { return $this->hasMany(Carton::class); }
    public function transferts() {
        return $this->hasMany(\App\Models\Transfert::class);
    }
    public function statsSaison($saison_id = null)
    {
        $saison_id = $saison_id ?? (\App\Models\Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first()?->id);
        return $this->hasOne(\App\Models\StatistiqueJoueur::class)
            ->where('saison_id', $saison_id);
    }
}
