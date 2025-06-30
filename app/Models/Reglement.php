<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reglement extends Model
{
    protected $fillable = [
        'titre', 'contenu', 'user_id', 'updated_by', 'saison_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }
    public function saison()
    {
        return $this->belongsTo(\App\Models\Saison::class);
    }
}
