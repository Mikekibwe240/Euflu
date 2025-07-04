<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rencontre extends Model
{
    protected $fillable = [
        'pool_id', 'saison_id', 'equipe1_id', 'equipe2_id', 'equipe1_libre', 'logo_equipe1_libre', 'equipe2_libre', 'logo_equipe2_libre', 'date', 'heure', 'stade', 'journee', 'type_rencontre', 'score_equipe1', 'score_equipe2', 'mvp_id', 'mvp_libre', 'mvp_libre_equipe', 'updated_by'
    ];

    public function pool() { return $this->belongsTo(Pool::class); }
    public function saison() { return $this->belongsTo(Saison::class); }
    public function equipe1() { return $this->belongsTo(Equipe::class, 'equipe1_id'); }
    public function equipe2() { return $this->belongsTo(Equipe::class, 'equipe2_id'); }
    public function buts() { return $this->hasMany(But::class); }
    public function cartons() { return $this->hasMany(Carton::class); }
    public function mvp() { return $this->belongsTo(Joueur::class, 'mvp_id'); }
    public function updatedBy() { return $this->belongsTo(User::class, 'updated_by'); }
    public function matchEffectifs() { return $this->hasMany(MatchEffectif::class, 'rencontre_id'); }
}
