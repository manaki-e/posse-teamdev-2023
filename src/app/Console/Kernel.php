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
        //テスト用に毎分実行
        $schedule->command('command:reset_distribution_point')->everyMinute();
        $schedule->command('command:subtract_product_point')->everyMinute();
        //毎月1日に実行
        // $schedule->command('command:reset_distribution_point')->monthly();
        // $schedule->command('command:subtract_product_point')->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}