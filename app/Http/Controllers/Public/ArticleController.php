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
        $query = Article::with(['saison', 'user', 'images']);
        if ($request->filled('saison_id')) {
            $query->where('saison_id', $request->saison_id);
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
        return view('public.articles', compact('articles', 'saisons'));
    }

    public function show($id)
    {
        $article = Article::with(['saison', 'user', 'images'])->findOrFail($id);
        return view('public.article_show', compact('article'));
    }
}
