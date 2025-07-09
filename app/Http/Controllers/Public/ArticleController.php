<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Saison;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $saisons = Saison::orderByDesc('date_debut')->get();
        $saison = null;
        $query = Article::with(['saison', 'user', 'images']);
        // Si "saison_id" est fourni et différent de "all", filtrer sur la saison choisie. Sinon, ne pas filtrer (toutes saisons).
        if ($request->filled('saison_id') && $request->saison_id !== 'all' && $request->saison_id !== '') {
            $saison = Saison::find($request->saison_id);
            if ($saison) {
                $query->where('saison_id', $saison->id);
            }
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
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
        $articles = $query->orderByDesc('created_at')->paginate(12)->withQueryString();
        return view('public.articles', compact('articles', 'saisons', 'saison'));
    }

    public function show($id)
    {
        $article = Article::with(['saison', 'user', 'images'])->findOrFail($id);
        return view('public.article_show', compact('article'));
    }
}
