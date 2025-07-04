<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchEffectif extends Model
{
    protected $fillable = [
        'rencontre_id',
        'equipe_id',
    ];

    public function rencontre()
    {
        return $this->belongsTo(Rencontre::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function joueurs()
    {
        return $this->hasMany(MatchEffectifJoueur::class);
    }

    public function remplacements()
    {
        return $this->hasMany(MatchRemplacement::class);
    }
}
