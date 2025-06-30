<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Saison extends Model
{
    protected $fillable = ['nom', 'date_debut', 'date_fin', 'etat', 'active'];

    public function pools() { return $this->hasMany(Pool::class); }
    public function equipes() { return $this->hasMany(Equipe::class); }
    public function joueurs() { return $this->hasMany(Joueur::class); }
    public function rencontres() { return $this->hasMany(Rencontre::class); }
    public function articles() { return $this->hasMany(Article::class); }
    public function reglements() { return $this->hasMany(Reglement::class); }
}
