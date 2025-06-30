<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'titre', 'contenu', 'media', 'date_publication', 'saison_id', 'user_id', 'video', 'published_at', 'updated_by'
    ];

    public function saison()
    {
        return $this->belongsTo(\App\Models\Saison::class);
    }

    public function images()
    {
        return $this->hasMany(\App\Models\ArticleImage::class);
    }
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    public function categories() 
    { 
        return $this->belongsToMany(Category::class, 'article_category'); 
    }
}
