<?php
// Kernel d'enregistrement des commandes artisan personnalisées
namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\FixEquipeLogos::class,
        \App\Console\Commands\FixEquipeLogoManual::class,
        \App\Console\Commands\CheckEquipeLogos::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // ...
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
