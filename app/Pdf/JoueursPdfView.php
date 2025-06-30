<?php

namespace App\Pdf;

use Illuminate\Contracts\View\View;

class JoueursPdfView
{
    protected $joueurs;

    public function __construct($joueurs)
    {
        $this->joueurs = $joueurs;
    }

    public function view(): View
    {
        return view('exports.joueurs_pdf', [
            'joueurs' => $this->joueurs
        ]);
    }
}
