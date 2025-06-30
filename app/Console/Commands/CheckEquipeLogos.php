<?php
// Script Artisan pour vérifier la correspondance entre les fichiers et les champs logo en base
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipe;

class CheckEquipeLogos extends Command
{
    protected $signature = 'equipe:check-logos';
    protected $description = 'Vérifie la correspondance entre les fichiers logos et les champs logo en base';

    public function handle()
    {
        $ok = 0;
        $missing = 0;
        foreach (Equipe::all() as $equipe) {
            if ($equipe->logo) {
                $path = storage_path('app/public/' . $equipe->logo);
                if (file_exists($path)) {
                    $this->info("[OK] {$equipe->nom} => {$equipe->logo}");
                    $ok++;
                } else {
                    $this->error("[ABSENT] {$equipe->nom} => {$equipe->logo}");
                    $missing++;
                }
            } else {
                $this->line("[AUCUN LOGO] {$equipe->nom}");
            }
        }
        $this->info("$ok logos trouvés, $missing logos manquants.");
    }
}
