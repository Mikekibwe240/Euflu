<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ArticlesExport implements FromView
{
    protected $articles;

    public function __construct($articles)
    {
        $this->articles = $articles;
    }

    public function view(): View
    {
        return view('exports.articles', [
            'articles' => $this->articles
        ]);
    }
}
