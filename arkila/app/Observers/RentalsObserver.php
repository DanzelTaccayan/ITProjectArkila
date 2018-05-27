<?php

namespace App\Observers;

use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\VanRental;
use App\User;

class RentalsObserver{

  public function created(VanRental $rent)
  {
    if($reserve->type == 'Online'){
      $user = User::find(Auth::id());
      $userAdmin = User::where('user_type', 'Super-Admin')->first();
      //dd($userAdmin->notify(new OnlineReserveAdminNotification($user, $reserve)));
      $userAdmin->notify(new OnlineRentalAdminNotification($rent, $reserve));
    }
  }

  public function updated(VanRental $rent)
  {
    if($rent->rent_type == 'Online'){
      if($rent->status == 'Accepted'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Accepted';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Declined'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Declined';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Cancelled'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Cancelled';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Departed'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Departed';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Refunded'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Refunded';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Paid'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Paid';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      }else if($rent->status == 'Expired'){
        $userCustomer = User::find($reserve->user_id);
        $case = 'Expired';
        $userCustomer->notify(new OnlineRentalCustomerNotification($userCustomer, $rent, $case));
      } 
    }
  }
}
