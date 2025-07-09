<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::view('/', 'welcome');

Route::redirect('dashboard', 'admin')->middleware(['auth', 'verified']);

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/saisons', [App\Http\Controllers\Admin\SaisonController::class, 'index'])->name('saisons.index');
    Route::get('/saisons/create', [App\Http\Controllers\Admin\SaisonController::class, 'create'])->name('saisons.create');
    Route::patch('/saisons/{saison}/activate', [App\Http\Controllers\Admin\SaisonController::class, 'activate'])->name('saisons.activate');
    Route::patch('/saisons/{saison}/deactivate', [App\Http\Controllers\Admin\SaisonController::class, 'deactivate'])->name('saisons.deactivate');
    Route::post('/saisons', [App\Http\Controllers\Admin\SaisonController::class, 'store'])->name('saisons.store');
    Route::get('/saisons/{saison}/edit', [App\Http\Controllers\Admin\SaisonController::class, 'edit'])->name('saisons.edit');
    Route::put('/saisons/{saison}', [App\Http\Controllers\Admin\SaisonController::class, 'update'])->name('saisons.update');
    Route::delete('/saisons/{saison}', [App\Http\Controllers\Admin\SaisonController::class, 'destroy'])->name('saisons.destroy');
    Route::get('/saisons/{saison}', [App\Http\Controllers\Admin\SaisonController::class, 'show'])->name('saisons.show');
    Route::get('/equipes', [App\Http\Controllers\Admin\EquipeController::class, 'index'])->name('equipes.index');
    Route::get('/equipes/create', [App\Http\Controllers\Admin\EquipeController::class, 'create'])->name('equipes.create');
    Route::get('/equipes/{equipe}/edit', [App\Http\Controllers\Admin\EquipeController::class, 'edit'])->name('equipes.edit');
    Route::put('/equipes/{equipe}', [App\Http\Controllers\Admin\EquipeController::class, 'update'])->name('equipes.update');
    Route::delete('/equipes/{equipe}', [App\Http\Controllers\Admin\EquipeController::class, 'destroy'])->name('equipes.destroy');
    Route::post('/equipes', [App\Http\Controllers\Admin\EquipeController::class, 'store'])->name('equipes.store');
    Route::get('/equipes/export', [App\Http\Controllers\Admin\EquipeController::class, 'export'])->name('equipes.export');
    Route::get('/equipes/export-pdf', [App\Http\Controllers\Admin\EquipeController::class, 'exportPdf'])->name('equipes.exportPdf');
    Route::get('/joueurs/create', [App\Http\Controllers\Admin\JoueurController::class, 'create'])->name('joueurs.create');
    Route::get('/joueurs', [App\Http\Controllers\Admin\JoueurController::class, 'index'])->name('joueurs.index');
    Route::post('/joueurs', [App\Http\Controllers\Admin\JoueurController::class, 'store'])->name('joueurs.store');
    Route::get('/joueurs/{joueur}/edit', [App\Http\Controllers\Admin\JoueurController::class, 'edit'])->name('joueurs.edit');
    Route::put('/joueurs/{joueur}', [App\Http\Controllers\Admin\JoueurController::class, 'update'])->name('joueurs.update');
    Route::delete('/joueurs/{joueur}', [App\Http\Controllers\Admin\JoueurController::class, 'destroy'])->name('joueurs.destroy');
    Route::get('/joueurs/export', [App\Http\Controllers\Admin\JoueurController::class, 'export'])->name('joueurs.export');
    Route::get('/joueurs/export-pdf', [App\Http\Controllers\Admin\JoueurController::class, 'exportPdf'])->name('joueurs.exportPdf');
    Route::get('/joueurs/export-par-equipe', [App\Http\Controllers\Admin\JoueurController::class, 'exportParEquipe'])->name('joueurs.exportParEquipe');
    Route::get('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [App\Http\Controllers\Admin\ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [App\Http\Controllers\Admin\ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [App\Http\Controllers\Admin\ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [App\Http\Controllers\Admin\ArticleController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/export', [App\Http\Controllers\Admin\ArticleController::class, 'export'])->name('articles.export');
    // Route pour afficher la fiche d'un article (admin)
    Route::get('articles/{article}', [\App\Http\Controllers\Admin\ArticleController::class, 'show'])
        ->name('articles.show');
    // Règlements CRUD
    Route::get('/reglements', [\App\Http\Controllers\ReglementController::class, 'index'])->name('reglements.index');
    Route::get('/reglements/create', [\App\Http\Controllers\ReglementController::class, 'create'])->name('reglements.create');
    Route::post('/reglements', [\App\Http\Controllers\ReglementController::class, 'store'])->name('reglements.store');
    Route::get('/reglements/{reglement}/edit', [\App\Http\Controllers\ReglementController::class, 'edit'])->name('reglements.edit');
    Route::put('/reglements/{reglement}', [\App\Http\Controllers\ReglementController::class, 'update'])->name('reglements.update');
    Route::delete('/reglements/{reglement}', [\App\Http\Controllers\ReglementController::class, 'destroy'])->name('reglements.destroy');
    Route::get('/reglements/export-pdf', [App\Http\Controllers\Admin\ReglementController::class, 'exportPdf'])->name('reglements.exportPdf');
    // Rencontres (matchs) CRUD et génération calendrier
    Route::get('/matchs', [\App\Http\Controllers\Admin\RencontreController::class, 'index'])->name('rencontres.index');
    Route::get('/matchs/create', [\App\Http\Controllers\Admin\RencontreController::class, 'create'])->name('rencontres.create');
    Route::post('/matchs', [\App\Http\Controllers\Admin\RencontreController::class, 'store'])->name('rencontres.store');
    Route::get('/matchs/{id}/edit', [\App\Http\Controllers\Admin\RencontreController::class, 'edit'])->name('rencontres.edit');
    Route::put('/matchs/{id}', [\App\Http\Controllers\Admin\RencontreController::class, 'update'])->name('rencontres.update');
    Route::delete('/matchs/{id}', [\App\Http\Controllers\Admin\RencontreController::class, 'destroy'])->name('rencontres.destroy');
    // Génération automatique calendrier
    Route::post('/matchs/generer', [\App\Http\Controllers\Admin\RencontreController::class, 'genererJournees'])->name('rencontres.generer');
    // Affichage du formulaire de génération du calendrier
    Route::get('/matchs/generer', [\App\Http\Controllers\Admin\RencontreController::class, 'genererForm'])->name('rencontres.genererForm');
    // Ajout match hors calendrier
    Route::post('/matchs/hors-calendrier', [\App\Http\Controllers\Admin\RencontreController::class, 'store'])->name('rencontres.horscalendrier');
    // Saisir/Modifier résultat d'une rencontre
    Route::get('/matchs/{id}/resultat', [\App\Http\Controllers\Admin\RencontreController::class, 'editResultat'])->name('rencontres.editResultat');
    // Enregistrer le résultat d'une rencontre
    Route::put('/matchs/{id}/resultat', [\App\Http\Controllers\Admin\RencontreController::class, 'updateResultat'])->name('rencontres.updateResultat');
    // Affichage du formulaire pour ajouter un match hors calendrier (GET)
    Route::get('/matchs/hors-calendrier', [\App\Http\Controllers\Admin\RencontreController::class, 'horsCalendrierForm'])->name('rencontres.horscalendrierForm');
    Route::get('/profile', function() { return view('admin.profile'); })->name('profile');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    // Route pour réinitialiser les résultats d'une rencontre
    Route::post('/matchs/{id}/reset-resultat', [\App\Http\Controllers\Admin\RencontreController::class, 'resetResultat'])->name('rencontres.resetResultat');
    Route::get('/matchs/export', [App\Http\Controllers\Admin\RencontreController::class, 'export'])->name('rencontres.export');
    Route::get('/matchs/export-pdf', [App\Http\Controllers\Admin\RencontreController::class, 'exportPdf'])->name('rencontres.exportPdf');
    Route::get('/joueurs/{joueur}', [App\Http\Controllers\Admin\JoueurController::class, 'show'])->name('joueurs.show');
    Route::get('/equipes/{equipe}', [App\Http\Controllers\Admin\EquipeController::class, 'show'])->name('equipes.show');
    Route::get('/matchs/{id}', [\App\Http\Controllers\Admin\RencontreController::class, 'show'])->name('rencontres.show');
    // Route pour afficher la fiche d'un règlement (admin)
    Route::get('reglements/{reglement}', [\App\Http\Controllers\ReglementController::class, 'show'])
        ->name('reglements.show');
    Route::get('/classement', [\App\Http\Controllers\Admin\ClassementAdminController::class, 'index'])->name('classement');

    Route::get('/transferts', [App\Http\Controllers\Admin\TransfertController::class, 'index'])->name('transferts.index');
    Route::post('/transferts', [App\Http\Controllers\Admin\TransfertController::class, 'store'])->name('transferts.store');
    // Affecter une équipe à un joueur libre
    Route::post('/joueurs/{joueur}/affecter-equipe', [App\Http\Controllers\Admin\JoueurController::class, 'affecterEquipe'])->name('joueurs.affecterEquipe');
    Route::post('/equipes/{equipe}/ajouter-joueur', [App\Http\Controllers\Admin\EquipeController::class, 'affecterJoueur'])->name('equipes.ajouterJoueur');
    Route::get('/classement-buteurs/{pool}', [\App\Http\Controllers\Admin\ClassementButeursAdminController::class, 'index'])->name('classement_buteurs');
    // Suppression d'un média d'un article (image ou vidéo)
    Route::delete('/articles/{article}/remove-media', [\App\Http\Controllers\Admin\ArticleController::class, 'removeMedia'])->name('articles.removeMedia');
    Route::get('/equipes/search', [App\Http\Controllers\Admin\EquipeController::class, 'ajaxSearch'])->name('equipes.ajaxSearch');
    Route::post('/equipes/{equipe}/affecter-pool', [App\Http\Controllers\Admin\EquipeController::class, 'affecterPool'])->name('equipes.affecterPool');
    Route::post('/equipes/{equipe}/retirer-pool', [App\Http\Controllers\Admin\EquipeController::class, 'retirerPool'])->name('equipes.retirerPool');
});

// Auth routes classiques (login/logout)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Routes publiques (visiteurs)
Route::prefix('equipes')->name('public.equipes.')->group(function () {
    Route::get('/', [App\Http\Controllers\Public\EquipeController::class, 'index'])->name('index');
    Route::get('/search', [App\Http\Controllers\Public\EquipeController::class, 'search'])->name('search');
    Route::get('/{id}', [App\Http\Controllers\Public\EquipeController::class, 'show'])->name('show');
    Route::get('/{id}/joueurs', [App\Http\Controllers\Public\EquipeJoueursController::class, 'index'])->name('joueurs');
});
Route::prefix('joueurs')->name('public.joueurs.')->group(function () {
    Route::get('/', [App\Http\Controllers\Public\JoueurController::class, 'search'])->name('search');
    Route::get('/{id}', [App\Http\Controllers\Public\JoueurController::class, 'show'])->name('show');
});
// Route publique pour la page joueurs (header + footer seulement)
// Route::get('/joueurs', function() {
//     return view('public.joueurs');
// })->name('public.joueurs');

// Route publique correcte pour la liste des joueurs (avec variables nécessaires)
Route::get('/joueurs', [App\Http\Controllers\Public\JoueurController::class, 'index'])->name('public.joueurs');
Route::get('/classement', [App\Http\Controllers\Public\ClassementController::class, 'index'])->name('public.classement');
Route::get('/equipes-par-poule', [App\Http\Controllers\Public\EquipesParPouleController::class, 'index'])->name('public.equipesParPoule');
// Route publique pour la liste des matchs
Route::get('/matchs', [\App\Http\Controllers\MatchPublicController::class, 'index'])->name('public.matchs.index');
Route::get('/matchs/{id}', [\App\Http\Controllers\MatchPublicController::class, 'show'])->name('public.match.show');
// Page publique des articles
Route::get('/articles', [\App\Http\Controllers\Public\ArticleController::class, 'index'])->name('public.articles.index');
Route::get('/articles/{id}', [\App\Http\Controllers\Public\ArticleController::class, 'show'])->name('public.articles.show');
// Page publique des règlements
Route::get('/reglements', [App\Http\Controllers\Public\ReglementController::class, 'index'])->name('public.reglements.index');
Route::get('/reglements/{id}', [App\Http\Controllers\Public\ReglementController::class, 'show'])->name('public.reglements.show');
// Page publique des buteurs
Route::get('/buteurs', [\App\Http\Controllers\Public\ClassementButeursController::class, 'index'])->name('public.buteurs');
// Page publique des vidéos
Route::view('/videos', 'public.videos')->name('public.videos');
// Page publique des stats
Route::view('/stats', 'public.stats')->name('public.stats');
// Page publique des awards
Route::view('/awards', 'public.awards')->name('public.awards');
// Génération PDF publique d'une feuille de match
Route::get('/matchs/{id}/pdf', [\App\Http\Controllers\MatchPublicController::class, 'pdf'])->name('public.match.pdf');
Route::get('/equipes', [App\Http\Controllers\Public\EquipeController::class, 'index'])->name('public.equipes');

// Route publique pour afficher une équipe (doit être placée APRÈS les routes admin pour éviter les conflits)
Route::get('/equipes/{equipe}', [App\Http\Controllers\EquipePublicController::class, 'show'])->name('equipes.show');
Route::view('/a-propos', 'public.a_propos')->name('a_propos');

require __DIR__.'/auth.php';
