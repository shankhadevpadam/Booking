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
        // clean activity log
        $schedule->command('activitylog:clean')->daily();

        // clean auth channel log activity
        $schedule->command('activitylog:clean auth --days=30')->daily();

        // send review notification daily
        $schedule->command('notification:review')->daily();

        // send coming week user list notification to admin
        $schedule->command('notification:user-list')->weekly()->sundays()->at('01:00')->timezone('Asia/Kathmandu');

        // send notification before 1 month
        $schedule->command('notification:user-notify --month')->daily();

        // send notification before week
        $schedule->command('notification:user-notify 7')->daily();

        // send notification admin on user arrival
        $schedule->command('notification:user-arrival')->dailyAt('01:00')->timezone('Asia/Kathmandu');

        // send notification admin on user arrival before hour
        $schedule->command('notification:user-arrival --hour')->everyMinute();

        // trash expired departure
        $schedule->command('trash:departure')->daily();
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
}
