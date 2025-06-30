<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfert extends Model
{
    protected $fillable = [
        'joueur_id',
        'from_equipe_id',
        'to_equipe_id',
        'date',
        'type',
    ];

    public function joueur() { return $this->belongsTo(Joueur::class); }
    public function fromEquipe() { return $this->belongsTo(Equipe::class, 'from_equipe_id'); }
    public function toEquipe() { return $this->belongsTo(Equipe::class, 'to_equipe_id'); }
}
