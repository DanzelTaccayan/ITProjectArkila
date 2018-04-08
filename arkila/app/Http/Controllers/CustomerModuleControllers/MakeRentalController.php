<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\User;
use App\Rental;
use App\VanModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Notifications\CustomerRent;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerRentalRequest;

use App\Http\Controllers\Controller;

class MakeRentalController extends Controller
{
    public function createRental()
    {
    	$vanmodels = VanModel::all();
    	return view('customermodule.user.rental.customerRental', compact('vanmodels'));
    }

    public function storeRental(CustomerRentalRequest $request)
    {
    	if($request->message == null){
    		$rent = Rental::create([
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
    		]);
    	}else{
    		$rent = Rental::create([
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

      $user = User::find(Auth::id());
      $user->notify(new CustomerRent($user, $rent));
    	return 	redirect(route('customermodule.user.transactions.customerTransactions'))->with('success', 'Successfully made a rental');
    }
}
