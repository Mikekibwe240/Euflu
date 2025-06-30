<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Article;
use App\Models\Reglement;
use App\Models\StatistiqueJoueur;
use App\Models\StatistiqueEquipe;
use App\Models\Saison;
use App\Models\Rencontre;
use App\Models\Pool;
use App\Models\Joueur;
use App\Models\Equipe;
use App\Models\Category;
use App\Models\Carton;
use App\Models\But;
use App\Models\ArticleImage;

class CleanAndSeedUsersTable extends Seeder
{
    public function run(): void
    {
        // Suppression des données liées avec vérification de l'existence des tables
        $tables = [
            'article_images' => ArticleImage::class,
            'buts' => But::class,
            'cartons' => Carton::class,
            'categories' => Category::class,
            'equipes' => Equipe::class,
            'joueurs' => Joueur::class,
            'pools' => Pool::class,
            'rencontres' => Rencontre::class,
            'saisons' => Saison::class,
            'statistique_equipes' => StatistiqueEquipe::class,
            'statistique_joueurs' => StatistiqueJoueur::class,
            'articles' => Article::class,
            'reglements' => Reglement::class,
            'users' => User::class,
        ];
        foreach ($tables as $table => $model) {
            if (Schema::hasTable($table)) {
                $model::query()->delete();
            }
        }

        // Création d'un super admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'super_admin',
        ]);

        // Création d'un admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
