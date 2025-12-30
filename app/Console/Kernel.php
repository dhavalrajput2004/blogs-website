<?php

namespace App\Console;

use App\Jobs\UserJob;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
         $schedule->command('send-emails')->everyTenSeconds();
      //  $schedule->call(function() {
       //     User::whereNull('email_verified_at')->delete();
     //   })->weekly();

     //$schedule->job(new UserJob)->everyTenSeconds();
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
