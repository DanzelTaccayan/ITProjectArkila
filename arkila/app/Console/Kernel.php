<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command(
           'db:backup --database=mysql --destination=local --destinationPath=/database-backup/arkilaBackup --compression=gzip'
         )->daily()
        ->before(function(){
            \File::cleanDirectory(storage_path('app/database-backup'));
        });

        $schedule->call(function() {
            $customerReservation = new \App\Http\Controllers\CustomerModuleControllers\MakeReservationController();
            $customerReservation->slotsAndExpiryDate();
        })->everyMinute();

        $schedule->call(function() {
            $customerRental = new \App\Http\Controllers\CustomerModuleControllers\MakeRentalController();
            $customerRental->refundExpiry();
        })->everyMinute();

        $schedule->call(function() {
            $expiryStatus = new \App\Http\Controllers\CustomerModuleControllers\MakeRentalController();
            $expiryStatus->expiredStatus();
        })->everyMinute();

        $schedule->call(function() {
            $expiry = new \App\Http\Controllers\TicketManagementController();
            $expiry->ticketExpiry();
        })->everyMinute();

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
