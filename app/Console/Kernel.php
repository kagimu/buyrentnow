<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function () {
            // Update user status based on last activity timestamp
            // Example: Set users as offline if last activity was more than 1 minute ago

            // You may customize this logic based on your requirements
            $offlineThreshold = now()->subMinutes(1);
            \App\Models\User::where('last_activity', '<', $offlineThreshold)->update(['online' => false]);
         })->everyMinute();

           $schedule->command('update:user-online-status')->dailyAt('0:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
        
    }

    protected $commands = [
    
        \App\Console\Commands\UpdateUserOnlineStatus::class,

    ];
}
