<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipe extends Model
{
    use SoftDeletes;

    protected $fillable = ['nom', 'pool_id', 'saison_id', 'coach', 'logo'];

    public function pool() { return $this->belongsTo(Pool::class); }
    public function saison() { return $this->belongsTo(Saison::class); }
    public function joueurs() { return $this->hasMany(Joueur::class); }
    public function rencontres1() { return $this->hasMany(Rencontre::class, 'equipe1_id'); }
    public function rencontres2() { return $this->hasMany(Rencontre::class, 'equipe2_id'); }
    public function statsSaison($saison_id = null)
    {
        $saison_id = $saison_id ?? (\App\Models\Saison::where('etat', 'ouverte')->orderByDesc('date_debut')->first()?->id);
        return $this->hasOne(\App\Models\StatistiqueEquipe::class)
            ->where('saison_id', $saison_id);
    }
    public function transferts() {
        return $this->hasMany(\App\Models\Transfert::class, 'from_equipe_id');
    }
    public function statsSaisons() {
        return $this->hasMany(\App\Models\StatistiqueEquipe::class);
    }
}
