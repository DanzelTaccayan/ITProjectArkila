<?php

namespace App\Observers;

use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OnlineRentalAdminNotification;
use App\Notifications\OnlineRentalCustomerNotification;
use App\Notifications\OnlineRentalDriverNotification;
use App\Notifications\WalkInRentalDriverNotification;
use App\VanRental;
use App\User;

class RentalsObserver{

  public function created(VanRental $rent)
  {
    if($rent->rent_type == 'Online' && $rent->status == 'Pending'){
      $user = User::find(Auth::id());
      $userAdmin = User::where('user_type', 'Super-Admin')->first();
      $userAdmin->notify(new OnlineRentalAdminNotification($user,$rent));
    }else if($rent->rent_type == 'Walk-in' && $rent->status == 'Paid'){
      $driverId = $rent->driver->id ?? null;
      if($driverId !== null){
        $userDriver = User::find($driverId) ?? null;
        $userAdmin = User::find(Auth::id());
        $userDriver->notify(new WalkInRentalDriverNotification($userAdmin, $rent));
      }
    }
  }

  public function updated(VanRental $rent)
  { 
    //dd($rent->driver->user->id ?? null);
    if($rent->rent_type == 'Online'){
      if($rent->status == 'Unpaid'){
        $case = 'Unpaid';
        $userAdmin = User::where('user_type', 'Super-Admin')->first();
        $userCustomer = User::find($rent->user_id);
        $driverId = $rent->driver->id ?? null;
        if($driverId !== null){
          $userDriver = User::find($driverId) ?? null;
          $userDriver->notify(new OnlineRentalDriverNotification($userAdmin, $rent, $case));
        }
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

        $driverId = $rent->driver->id ?? null;
        if($driverId !== null){
          $userDriver = User::find() ?? null;
          $userDriver->notify(new OnlineRentalDriverNotification($userAdmin, $rent, $case));
        }
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
    }else if($rent->rent_type == 'Walk-in'){
      if($rent->status == 'Refunded'){
        $driverId = $rent->driver->id ?? null;
        if($driverId !== null){
          $userDriver = User::find($driverId) ?? null;
          $userAdmin = User::find(Auth::id());
          $userDriver->notify(new WalkInRentalDriverNotification($userAdmin, $rent));
        }
      }
    }
  }
}
