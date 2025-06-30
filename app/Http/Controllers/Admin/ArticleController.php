<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Saison;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exports\ArticlesExport;
use Maatwebsite\Excel\Facades\Excel;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        $query = Article::with(['saison', 'user']);
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        if ($request->filled('titre')) {
            $query->where('titre', $request->titre);
        }
        if ($request->filled('auteur')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->auteur . '%');
            });
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('titre', 'like', "%$q%")
                     ->orWhere('contenu', 'like', "%$q%")
                     ->orWhereHas('user', function($u) use ($q) {
                         $u->where('name', 'like', "%$q%") ;
                     });
            });
        }
        $articles = $query->orderByDesc('created_at')->paginate(20)->withQueryString();
        return view('admin.articles.index', compact('articles', 'saisons'));
    }

    public function create()
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        return view('admin.articles.create', compact('saisons'));
    }

    public function store(Request $request)
    {
        $messages = [
            'titre.required' => 'Le titre est obligatoire.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'saison_id.required' => 'La saison est obligatoire.',
            'saison_id.exists' => 'La saison sélectionnée n’existe pas.',
        ];
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'saison_id' => 'required|exists:saisons,id',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'images' => 'nullable|array|max:3',
            'video' => 'nullable|file|mimetypes:video/mp4|max:20480',
            'published_at' => 'nullable|date',
        ], $messages);
        $data = $request->only(['titre', 'contenu', 'saison_id']);
        // Vidéo locale (mp4)
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('articles/videos', 'public');
        } else {
            $data['video'] = null;
        }
        $data['published_at'] = $request->filled('published_at') ? $request->published_at : null;
        // Remplir date_publication automatiquement
        $data['date_publication'] = $request->filled('published_at') ? substr($request->published_at, 0, 10) : now()->toDateString();
        $data['user_id'] = auth()->id();
        $article = Article::create($data);
        // Suppression de la gestion des catégories
        // Gestion des images (Image 1, 2, 3)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                if ($img) {
                    $path = $img->store('articles', 'public');
                    $article->images()->create(['path' => $path]);
                }
            }
        }
        \Log::info('Création d\'un article', ['titre' => $data['titre'], 'admin_id' => \Auth::id()]);
        return redirect()->route('admin.articles.index')->with('success', 'Article ajouté avec succès.');
    }

    public function edit(Article $article)
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        return view('admin.articles.edit', compact('article', 'saisons'));
    }

    public function update(Request $request, Article $article)
    {
        $messages = [
            'titre.required' => 'Le titre est obligatoire.',
            'contenu.required' => 'Le contenu est obligatoire.',
            'saison_id.required' => 'La saison est obligatoire.',
            'saison_id.exists' => 'La saison sélectionnée n’existe pas.',
        ];
        $request->validate([
            'titre' => 'required|string|max:255',
            'contenu' => 'required|string',
            'saison_id' => 'required|exists:saisons,id',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'images' => 'nullable|array|max:3',
            'video' => 'nullable|file|mimetypes:video/mp4|max:20480',
            'published_at' => 'nullable|date',
        ], $messages);
        $data = $request->only(['titre', 'contenu', 'saison_id']);
        // Vidéo locale (mp4)
        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('articles/videos', 'public');
        }
        $data['published_at'] = $request->filled('published_at') ? $request->published_at : null;
        // Remplir date_publication automatiquement
        $data['date_publication'] = $request->filled('published_at') ? substr($request->published_at, 0, 10) : now()->toDateString();
        $data['updated_by'] = auth()->id();
        $article->update($data);
        // Suppression des anciennes images si de nouvelles images sont uploadées
        if ($request->hasFile('images')) {
            foreach ($article->images as $img) {
                \Storage::disk('public')->delete($img->path);
                $img->delete();
            }
            foreach ($request->file('images') as $img) {
                if ($img) {
                    $path = $img->store('articles', 'public');
                    $article->images()->create(['path' => $path]);
                }
            }
        }
        \Log::info('Modification d\'un article', ['article_id' => $article->id, 'admin_id' => \Auth::id()]);
        return redirect()->route('admin.articles.index')->with('success', 'Article modifié avec succès.');
    }

    public function destroy(Article $article)
    {
        $titre = $article->titre;
        $article->delete();
        Log::info('Suppression d\'un article', ['titre' => $titre, 'admin_id' => Auth::id()]);
        return redirect()->route('admin.articles.index')->with('success', "L’article '$titre' a bien été supprimé.");
    }

    public function export(Request $request)
    {
        $query = Article::with(['saison', 'user', 'updatedBy']);
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
        }
        if ($request->filled('titre')) {
            $query->where('titre', $request->titre);
        }
        if ($request->filled('auteur')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->auteur . '%');
            });
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('titre', 'like', "%$q%")
                     ->orWhere('contenu', 'like', "%$q%")
                     ->orWhereHas('user', function($u) use ($q) {
                         $u->where('name', 'like', "%$q%") ;
                     });
            });
        }
        $articles = $query->orderByDesc('created_at')->get();
        return Excel::download(new ArticlesExport($articles), 'articles.xlsx');
    }

    public function show(Article $article)
    {
        $article->load(['saison', 'user']);
        return view('admin.articles.show', compact('article'));
    }
}
