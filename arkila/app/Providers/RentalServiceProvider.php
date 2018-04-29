<?php

namespace App\Providers;

// use App\Rental;
use App\Observers\RentalsObserver;
use Illuminate\Support\ServiceProvider;

class RentalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Rental::observe(RentalsObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
