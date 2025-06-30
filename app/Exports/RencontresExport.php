<?php

namespace App\Exports;

use App\Models\Rencontre;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RencontresExport implements FromView
{
    protected $rencontres;

    public function __construct($rencontres)
    {
        $this->rencontres = $rencontres;
    }

    public function view(): View
    {
        return view('exports.rencontres', [
            'rencontres' => $this->rencontres
        ]);
    }
}
