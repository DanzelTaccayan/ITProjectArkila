<?php

namespace App\Observers;

use Auth;
use App\User;
use App\Trip;
use App\Notifications\TripReportsAdminNotifications;
use App\Notifications\TripReportsDriverNotifications;
use Illuminate\Support\Facades\Notification;

class TripReportsObserver
{
    public function created(Trip $trip)
    {
        if($trip->reportedBy == 'Driver'){
            $userAdmin = User::where('user_type', 'Super-Admin')->first();
            $userDriver = User::find(Auth::id());
            $userAdmin->notify(new TripReportsAdminNotifications($userDriver, $trip));
        }else if($trip->reportedBy == 'Super-Admin'){
            $userDriver = User::find($trip->driver->user->id);
            $userAdmin = User::where('user_type', 'Super-Admin')->first();
            $userDriver->notify(new TripReportsDriverNotifications($userAdmin, $trip));
        }
    }

    public function updated(Trip $trip)
    {
        if($trip->reportedBy == 'Driver' && ($trip->report_status = 'Accepted' || $trip->report_status = 'Declined')){
            $userDriver = User::find($trip->driver->user->id);
            $userAdmin = User::where('user_type', 'Super-Admin')->first();
            $userDriver->notify(new TripReportsDriverNotifications($userAdmin, $trip));
        }
    }
}