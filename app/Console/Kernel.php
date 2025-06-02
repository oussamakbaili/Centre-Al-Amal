<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            app(\App\Http\Controllers\Admin\PresenceController::class)->ajouterAbsentsAutomatiquement();
        })->everyMinute(); // ou ->hourly();

        // Run every 5 minutes to check for ended sessions and fill absences
        $schedule->command('absences:fill')->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

}
