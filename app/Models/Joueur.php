<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Joueur extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'prenom', 'date_naissance', 'poste', 'equipe_id', 'photo', 'saison_id'];

    public function equipe() { return $this->belongsTo(Equipe::class); }
    public function saison() { return $this->belongsTo(Saison::class); }
    public function buts() { return $this->hasMany(But::class); }
    public function cartons() { return $this->hasMany(Carton::class); }
    public function transferts() {
        return $this->hasMany(\App\Models\Transfert::class);
    }
}
