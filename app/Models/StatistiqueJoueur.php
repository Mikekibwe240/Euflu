<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistiqueJoueur extends Model
{
    protected $fillable = [
        'joueur_id', 'saison_id', 'buts', 'cartons_jaunes', 'cartons_rouges', 'mvp'
    ];
}
