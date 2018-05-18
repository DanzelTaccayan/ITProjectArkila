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
    	$vanmodels = VanModel::all();
    	return view('customermodule.user.rental.customerRental', compact('vanmodels'));
    }

    public function storeRental(CustomerRentalRequest $request)
    {
    	// dd($request->van_model == null ? true : false);
    	if($request->message == null){
    		$rent = VanRental::create([
    			"user_id" => Auth::id(),
	    		"customer_name" => Auth::user()->first_name . ' ' . Auth::user()->middle_name . ' ' . Auth::user()->last_name,
	    		"departure_date" => $request->date,
	    		"departure_time" => $request->time,
	    		"model_id" => $request->van_model,
	    		"number_of_days" => $request->numberOfDays,
	    		"destination" => $request->rentalDestination,
	    		"contact_number" => $request->contactNumber,
	    		"status" => 'Pending',
	    		"rent_type" => 'Online',
    		]);
    	}else{
    		$rent = VanRental::create([
    			"user_id" => Auth::id(),
	    		"first_name" => Auth::user()->first_name,
	    		"last_name" => Auth::user()->last_name,
	    		"middle_name" => Auth::user()->middle_name,
	    		"departure_date" => $request->date,
	    		"departure_time" => $request->time,
	    		"model_id" => $request->van_model,
	    		"number_of_days" => $request->numberOfDays,
	    		"destination" => $request->rentalDestination,
	    		"contact_number" => $request->contactNumber,
	    		"status" => 'Pending',
	    		"rent_type" => 'Online',
	    		"comments" => $request->message
    		]);
    	}

      // $user = User::find(Auth::id());
      // $user->notify(new CustomerRent($user, $rent));
    	return 	redirect(route('customermodule.user.transactions.customerTransactions'))->with('success', 'Successfully made a rental');
    }
}
