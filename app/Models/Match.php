<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $fillable = [
        'domicile', 'exterieur', 'date_heure', 'stade', 'phase', 'pool_id', 'hors_calendrier', 'saison_id'
    ];

    public function pool()
    {
        return $this->belongsTo(Pool::class);
    }
    public function saison()
    {
        return $this->belongsTo(Saison::class);
    }
}
