<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EquipesExport implements FromView
{
    protected $equipes;

    public function __construct($equipes)
    {
        $this->equipes = $equipes;
    }

    public function view(): View
    {
        return view('exports.equipes', [
            'equipes' => $this->equipes
        ]);
    }
}
