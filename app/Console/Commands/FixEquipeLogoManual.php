<?php
// Script Artisan pour corriger le champ logo d'une équipe précise
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Equipe;

class FixEquipeLogoManual extends Command
{
    protected $signature = 'equipe:fix-logo {id} {filename}';
    protected $description = 'Corrige le champ logo d\'une équipe (force logos/filename)';

    public function handle()
    {
        $id = $this->argument('id');
        $filename = $this->argument('filename');
        $equipe = Equipe::find($id);
        if (!$equipe) {
            $this->error('Équipe non trouvée');
            return;
        }
        $equipe->logo = 'logos/' . $filename;
        $equipe->save();
        $this->info("Logo corrigé pour {$equipe->nom} : logos/$filename");
    }
}
