<?php
// Script Artisan pour corriger les chemins de logo des équipes
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipe;

class FixEquipeLogos extends Command
{
    protected $signature = 'equipe:fix-logos';
    protected $description = 'Corrige les chemins de logo des équipes (enlève les chemins absolus, ne garde que logos/nom.png)';

    public function handle()
    {
        $count = 0;
        foreach (Equipe::all() as $equipe) {
            if ($equipe->logo && (str_contains($equipe->logo, ':\\') || str_contains($equipe->logo, '/'))) {
                $filename = basename($equipe->logo);
                $newPath = 'logos/' . $filename;
                if ($equipe->logo !== $newPath) {
                    $equipe->logo = $newPath;
                    $equipe->save();
                    $this->info("Corrigé: {$equipe->nom} => $newPath");
                    $count++;
                }
            }
        }
        $this->info("$count logos corrigés.");
    }
}
