<?php

namespace App\Observers;

use Auth;
use App\User;
use App\Trip;
use App\Notifications\TripReportsAdminNotification;
use App\Notifications\TripReportsDriverNotification;
use Illuminate\Support\Facades\Notification;

class TripReportsObserver
{
    public function created(Trip $trip)
    {
        if($trip->reportedBy == 'Driver' && $trip->report_status == 'Pending'){
            $userAdmin = User::where('user_type', 'Super-Admin')->first();
            $userDriver = User::find(Auth::id());
            $userAdmin->notify(new TripReportsAdminNotification($userDriver, $trip));
        }else if($trip->reportedBy == 'Super-Admin' && $trip->report_status == 'Accepted'){
            $userDriver = User::find($trip->driver->user->id);
            $userAdmin = User::find(Auth::id());
            $userDriver->notify(new TripReportsDriverNotification($userAdmin, $trip));
        }
    }

    public function updated(Trip $trip)
    {
        if($trip->reportedBy == 'Driver' && ($trip->report_status == 'Accepted' || $trip->report_status == 'Declined')){
            $userDriver = User::find($trip->driver->user->id);
            $userAdmin = User::find(Auth::id());
            $userDriver->notify(new TripReportsDriverNotification($userAdmin, $trip));
        }
    }
}