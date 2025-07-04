<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MatchRemplacement extends Model
{
    protected $fillable = [
        'match_effectif_id',
        'joueur_remplacant_id',
        'joueur_remplace_id',
        'minute',
    ];

    public function effectif()
    {
        return $this->belongsTo(MatchEffectif::class, 'match_effectif_id');
    }

    public function remplaçant()
    {
        return $this->belongsTo(Joueur::class, 'joueur_remplacant_id');
    }

    public function remplacé()
    {
        return $this->belongsTo(Joueur::class, 'joueur_remplace_id');
    }
}
