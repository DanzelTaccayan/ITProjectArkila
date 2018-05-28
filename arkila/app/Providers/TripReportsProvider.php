<?php

namespace App\Providers;

use App\Trip;
use App\TripReportsObserver;
use Illuminate\Support\ServiceProvider;

class TripReportsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Trip::observe(TripReportsObserver::class);
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
