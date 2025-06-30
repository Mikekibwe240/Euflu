<?php

namespace App\Exports;

use App\Models\Equipe;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\JoueursExportParEquipe;

class JoueursParEquipeExport implements WithMultipleSheets
{
    protected $equipes;

    public function __construct($equipes)
    {
        $this->equipes = $equipes;
    }

    public function sheets(): array
    {
        $sheets = [];
        foreach ($this->equipes as $equipe) {
            $sheets[] = new JoueursExportParEquipe($equipe->joueurs, $equipe->nom);
        }
        return $sheets;
    }
}
