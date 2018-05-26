<?php

namespace App\Observers;

use App\User;
use App\Reservation;
use Auth;
use App\Notifications\CustomerReserve;
class ReservationObserver
{
    public function created(Reservation $reserve)
    {
        if($reserve->user_id != null){
            $user = User::find(Auth::id());
            $userAdmin = User::where('user_type', 'Super-Admin')->first();

            $userAdmin->notify(new CustomerReserve($user, $reserve));
        }
    }
    
}