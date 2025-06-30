<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class But extends Model
{
    protected $fillable = ['rencontre_id', 'joueur_id', 'equipe_id', 'minute', 'nom_libre', 'equipe_libre_nom'];
    public function rencontre() { return $this->belongsTo(Rencontre::class); }
    public function joueur() { return $this->belongsTo(Joueur::class); }
    public function equipe() { return $this->belongsTo(Equipe::class); }
}
