<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Destination;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('layouts.partials.queue_sidebar', function($view){
            $terminals = Destination::has('vanQueue');

//            $view->with([
//                'terminalsSideBar' => $terminalsSideBar,
//                'tripsSideBar' => $tripsSideBar,
//                'driversSideBar' => $driversSideBar,
//                'vansSideBar' => $vansSideBar,
//                'terminalsTicketSideBar' => $terminalsTicketSideBar
//            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
