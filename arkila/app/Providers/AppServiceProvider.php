<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Terminal;
use App\Trip;
use App\Member;
use App\Van;

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

//        view()->composer('layouts.partials.queue_sidebar', function($view){
//            $terminalsSideBar = Terminal::whereNotIn('terminal_id',[auth()->user()->terminal_id])->get();
//            $tripsSideBar = Trip::whereNotNull('queue_number')->orderBy('queue_number')->get();
//
//            $driversSideBar = Member::whereNotIn('member_id', function($query){
//                $query->select('driver_id')->from('trip')->whereNotNull('queue_number');
//            })->get();
//
//            $vansSideBar = Van::whereNotIn('plate_number', function($query){
//                $query->select('plate_number')
//                    ->from('trip')
//                    ->where('has_privilege',1)
//                    ->orWhereNotNull('queue_number');
//            })->get();
//
//            $terminalsTicketSideBar = Terminal::whereNotIn('terminal_id',[auth()->user()->terminal_id])->get();
//
//            $view->with([
//                'terminalsSideBar' => $terminalsSideBar,
//                'tripsSideBar' => $tripsSideBar,
//                'driversSideBar' => $driversSideBar,
//                'vansSideBar' => $vansSideBar,
//                'terminalsTicketSideBar' => $terminalsTicketSideBar
//            ]);
//        });
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
