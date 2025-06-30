<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JoueursExport implements FromView
{
    protected $joueurs;

    public function __construct($joueurs)
    {
        $this->joueurs = $joueurs;
    }

    public function view(): View
    {
        return view('exports.joueurs', [
            'joueurs' => $this->joueurs
        ]);
    }
}
