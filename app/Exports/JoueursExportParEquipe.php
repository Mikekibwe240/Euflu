<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;

class JoueursExportParEquipe implements FromView, WithTitle
{
    protected $joueurs;
    protected $equipeNom;

    public function __construct($joueurs, $equipeNom)
    {
        $this->joueurs = $joueurs;
        $this->equipeNom = $equipeNom;
    }

    public function view(): View
    {
        return view('exports.joueurs_par_equipe', [
            'joueurs' => $this->joueurs,
            'equipeNom' => $this->equipeNom
        ]);
    }

    public function title(): string
    {
        return $this->equipeNom;
    }
}
