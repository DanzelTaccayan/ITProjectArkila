<?php

namespace App\Observers;

use App\User;
use App\Reservation;
use Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OnlineReserveAdminNotification;
use App\Notifications\OnlineReserveCustomerNotification;
class ReservationObserver
{
    //Admin Notification for Reservation
    public function created(Reservation $reserve)
    {
        if($reserve->type == 'Online'){
            
            $user = User::find(Auth::id());
            $userAdmin = User::where('user_type', 'Super-Admin')->first();
            //dd($userAdmin->notify(new OnlineReserveAdminNotification($user, $reserve)));
            $userAdmin->notify(new OnlineReserveAdminNotification($user, $reserve));
        }
    }

    //Customer Notification for Reservation
    public function updated(Reservation $reserve)
    {
        $case = null;
        
        if($reserve->type == 'Online'){
            //Reservation Paid
        if($reserve->status == 'PAID'){
            $userCustomer = User::find($reserve->user_id);
            $case = 'Paid';
            //dd($case);
            $userCustomer->notify(new OnlineReserveCustomerNotification($userCustomer, $reserve, $case));
            
        }

        //Reservation Expired
        if($reserve->status == 'EXPIRED'){
            $userCustomer = User::find($reserve->user_id);
            $case = 'Expired';
            $userCustomer->notify(new OnlineReserveCustomerNotification($userCustomer, $reserve, $case));
        }

        //Reservation Refund
        if($reserve->status == 'REFUNDED'){
            $userCustomer = User::find($reserve->user_id);
            $case = 'Refund';
            $userCustomer->notify(new OnlineReserveCustomerNotification($userCustomer, $reserve, $case));
        }

        //Reservation Departed
        if($reserve->status == 'DEPARTED'){
            $userCustomer = User::find($reserve->user_id);
            $case = 'Departed';
            $userCustomer->notify(new OnlineReserveCustomerNotification($userCustomer, $reserve, $case));
        }
        }
    }
    
}