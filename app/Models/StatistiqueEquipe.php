<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistiqueEquipe extends Model
{
    protected $fillable = [
        'equipe_id', 'saison_id', 'points', 'victoires', 'nuls', 'defaites', 'buts_pour', 'buts_contre', 'cartons_jaunes', 'cartons_rouges'
    ];
}
