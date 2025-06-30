<?php

namespace App\Pdf;

use Illuminate\Contracts\View\View;

class EquipesPdfView
{
    protected $equipes;

    public function __construct($equipes)
    {
        $this->equipes = $equipes;
    }

    public function view(): View
    {
        return view('exports.equipes_pdf', [
            'equipes' => $this->equipes
        ]);
    }
}
