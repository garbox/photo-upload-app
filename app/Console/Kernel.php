<?php

namespace App\Console;

use App\Jobs\RemoveExpiredPhotos; // Import your job here
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\RemoveExpiredPhotosJob;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        \App\Console\Commands\RemoveExpiredPhotosCommand::class,  // Register your custom command
    ];


    protected function schedule(Schedule $schedule){
        // Schedule the job to run every hour RemoveExpiredPhotosCommand
        $schedule->job(new RemoveExpiredPhotosJob)->hourly();
    }

    protected function commands(){
        $this->load(__DIR__.'/Commands');
    }
}
