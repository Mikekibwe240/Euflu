<?php

namespace App\Pdf;

use Illuminate\Contracts\View\View;

class RencontresPdfView
{
    protected $rencontres;

    public function __construct($rencontres)
    {
        $this->rencontres = $rencontres;
    }

    public function view(): View
    {
        return view('exports.rencontres_pdf', [
            'rencontres' => $this->rencontres
        ]);
    }
}
