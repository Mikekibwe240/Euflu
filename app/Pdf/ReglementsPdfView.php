<?php

namespace App\Pdf;

use Illuminate\Contracts\View\View;

class ReglementsPdfView
{
    protected $reglements;

    public function __construct($reglements)
    {
        $this->reglements = $reglements;
    }

    public function view(): View
    {
        return view('exports.reglements_pdf', [
            'reglements' => $this->reglements
        ]);
    }
}
