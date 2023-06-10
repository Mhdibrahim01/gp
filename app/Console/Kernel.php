<?php

namespace App\Console;

use App\Console\Commands\AutoDonation;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\BloodInventoryAuto;
use App\Console\Commands\AppointmentSlotCommand;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
   $schedule->command(AutoDonation::class); 

       $schedule->command(AppointmentSlotCommand::class); 
  $schedule->command(BloodInventoryAuto::class); 

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
