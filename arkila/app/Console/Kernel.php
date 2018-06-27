<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\RentalOneDayBeforeNotification;
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

        $schedule->call(function() {
            $now = \Carbon\Carbon::now()->format('Y-m-d');
            $rentals = \App\VanRental::selectRaw('COUNT(departure_date) as num, departure_date')
              ->where('status', 'Paid')->groupBy('departure_date')->get();

            if(count($rentals) > 0){
              foreach($rentals as $rental){
                $dateBeforeRental = \Carbon\Carbon::parse($rental->departure_date)->subday();
                if($dateBeforeRental->format('Y-m-d') == $now){
                  $admin = \App\User::where('user_type', 'Super-Admin')->first();
                  $departure_date = \Carbon\Carbon::parse($rental->departure_date)->format('Y-m-d');
                  $admin->notify(new RentalOneDayBeforeNotification($rental->num, $departure_date));
                }
              }
            }
        })->daily();

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
