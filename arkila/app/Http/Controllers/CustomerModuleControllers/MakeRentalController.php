<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\User;
use App\VanRental;
use App\VanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerRentalRequest;

use App\Http\Controllers\Controller;

class MakeRentalController extends Controller
{
    public function __construct()
    {
      $this->middleware('online-rental');
    }

    public function createRental()
    {
    	return view('customermodule.user.rental.customerRental');
    }

    public function storeRental(CustomerRentalRequest $request)
    {

      $carbonDate = new Carbon($request->date);
      $departedDate = $carbonDate->format('Y-m-d');
      $rent = VanRental::create([
        "user_id" => Auth::id(),
        "customer_name" => Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name,
        "departure_date" => $departedDate,
        "departure_time" => $request->time,
        "number_of_days" => $request->numberOfDays,
        "destination" => $request->rentalDestination,
        "contact_number" => $request->contactNumber,
        "status" => 'Pending',
        "rent_type" => 'Online',
        "comments" => $request->message !== null ? $request->message : null,
      ]);
      //dd($rent->departure_date);
      // $user = User::find(Auth::id());
      // $user->notify(new CustomerRent($user, $rent));
    	return 	redirect(route('customermodule.user.transactions.customerTransactions'))->with('success', 'Successfully made a rental');
    }
}
