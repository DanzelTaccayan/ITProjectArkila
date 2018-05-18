<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Destination;
use App\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerReservationRequest;

class MakeReservationController extends Controller
{
    public function __construct()
    {
      $this->middleware('online-reservation');
    }
    public function createReservation()
    {
    	$destinations = Destination::all();
    	return view('customermodule.user.reservation.customerReservation', compact('destinations'));
    }

    public function storeReservation(CustomerReservationRequest $request)
    {
    	$fullName = null;
    	if(Auth::user()->middle_name == null){
    		$fullName = Auth::user()->first_name . " " . Auth::user()->last_name;
    	}else{
    		$fullName = Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->last_name;
    	}

    	$seat = $request->numberOfSeats;
        $destinationReq = $request->destination;
        $findDest = Destination::all();

        foreach ($findDest->where('destination_id', $destinationReq) as $find) {
            $findAmount = $find->amount;
        }
        $total = $findAmount*$seat;

    	if($request->message == null){
    		Reservation::create([
    			"user_id" => Auth::id(),
    			"destination_id" => $request->destination,
    			"name" => $fullName,
    			"departure_date" => $request->date,
    			"departure_time" => $request->time,
    			"number_of_seats" => $request->numberOfSeats,
    			"contact_number" => $request->contactNumber,
    			"status" => "Pending",
    			"amount" => $total,
    			"type" => "Online",
    			"comments" => $request->message,
    		]);
    	}else{
    		Reservation::create([
    			"user_id" => Auth::id(),
    			"destination_id" => $request->destination,
    			"name" => $fullName,
    			"departure_date" => $request->date,
    			"departure_time" => $request->time,
    			"number_of_seats" => $request->numberOfSeats,
    			"contact_number" => $request->contactNumber,
    			"status" => "Pending",
    			"amount" => $total,
    			"type" => "Online",
    			"comments" => $request->message,
    		]);
    	}

    	return redirect(route('customermodule.user.transactions.customerTransactions'))->with('success', 'Successfully made a Reservation');
    }
}
