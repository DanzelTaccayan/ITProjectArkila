<?php

namespace App\Observers;

use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OnlineReserveAdminNotification;
use App\VanRental;
use App\User;

class RentalsObserver{

  public function created(VanRental $rent)
  {
    if($rent->type == 'Online'){
      $user = User::find(Auth::id());
      $userAdmin = User::where('user_type', 'Super-Admin')->first();
      //dd($userAdmin->notify(new OnlineReserveAdminNotification($user, $reserve)));
      $userAdmin->notify(new OnlineRentalAdminNotification($user,$rent));
    }
  }

  public function updated(VanRental $rent)
  {
    if($rent->rent_type == 'Online'){
      if($rent->status == 'Unpaid'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Unpaid';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Declined'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Declined';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Cancelled'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Cancelled';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));

        $user = User::find(Auth::id());
        $userAdmin = User::where('user_type', 'Super-Admin')->first();
        //dd($userAdmin->notify(new OnlineReserveAdminNotification($user, $reserve)));
        $userAdmin->notify(new OnlineRentalAdminNotification($user,$rent));
      }else if($rent->status == 'Departed'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Departed';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Refunded'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Refunded';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Paid'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Paid';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Expired'){
        $userCustomer = User::find($rent->user_id);
        $case = 'Expired';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'No Van Available'){
        $userCustomer = User::find($rent->user_id);
        $case = 'No Van Available';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      } 
    }
  }
}
