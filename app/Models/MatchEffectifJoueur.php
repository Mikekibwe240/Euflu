<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchEffectifJoueur extends Model
{
    protected $fillable = [
        'match_effectif_id',
        'joueur_id',
        'type',
        'ordre',
    ];

    public function effectif()
    {
        return $this->belongsTo(MatchEffectif::class, 'match_effectif_id');
    }

    public function joueur()
    {
        return $this->belongsTo(Joueur::class);
    }
}
