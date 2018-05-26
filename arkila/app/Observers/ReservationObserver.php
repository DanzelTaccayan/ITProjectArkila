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
        if($reserve->user_id != null && $reserve->type == 'online'){
            
            $user = User::find(Auth::id());
            $userAdmin = User::where('user_type', 'Super-Admin')->first();

            $userAdmin->notify(new CustomerReserve($user, $reserve));
        }
    }

    
    public function updated(Reservation $reserve)
    {
        //Reservation Paid
        if($reserve->user_id != null && $reserve->refund_code != null 
            && $reserve->status == 'PAID' && $reserve->type == 'online' && $reserve->date_paid != null){
            
            $user = User::where('user_type', 'Super-Admin')->first();
            $userCustomer = User::find($reserve->user_id);

            $userCustomer->notify(new CustomerReserve($user, $reserve));
        }
    }
    
}