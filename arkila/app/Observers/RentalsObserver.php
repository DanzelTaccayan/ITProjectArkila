<?php

namespace App\Observers;

use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Rental;
use App\User;

class RentalsObserver{

  public function created(Rental $rent)
  {
    $user = User::find(Auth::id());
    $userDriverAndAdmin = User::join('member', 'users.id', '=', 'member.user_id')
      ->join('member_van', 'member.member_id', '=', 'member_van.member_id')
      ->join('van', 'member_van.plate_number', '=', 'van.plate_number')
      ->join('van_model', 'van.model_id', '=', 'van_model.model_id')
      ->where('user_type', 'Super-Admin')
      ->orWhere('user_type', 'Driver')
      ->where('van_model.model_id', $rent->model_id)
      ->get();

    foreach($userDriverAndAdmin as $userNotif){
      $userNotif->notify(new CustomerRent($user, $rent));
    }
  }

  public function updated(Rental $rent)
  {
    
  }
}
