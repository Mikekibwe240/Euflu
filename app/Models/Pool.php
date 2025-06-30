<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $fillable = ['nom', 'saison_id'];

    public function saison() { return $this->belongsTo(Saison::class); }
    public function equipes() { return $this->hasMany(Equipe::class); }
    public function rencontres() { return $this->hasMany(Rencontre::class); }
}
