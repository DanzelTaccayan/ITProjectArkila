<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Destination;
use App\ReservationDate;
use App\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerReservationRequest;
use Session;

class MakeReservationController extends Controller
{
    public function __construct()
    {
      $this->middleware('online-reservation');
    }
    public function createReservation()
    {
		$destinations = Destination::allRoute()->orderBy('destination_name')->get();
    	return view('customermodule.user.reservation.selectDestination', compact('destinations'));
	}
	
	public function showDetails(Request $request)
	{
		$wow = $request->destination;
		Session::put('key', $wow);

		return redirect('/home/reservation/show-reservations');
	}
	public function reservationCreate(ReservationDate $reservation)
	{

		$main = Destination::mainTerminal()->get()->first();
		$requested = Session::get('key');
		$dropOff = Destination::where('destination_id', $requested)->get()->first();
		return view('customermodule.user.reservation.createReservation', compact('reservation', 'main', 'dropOff'));
	}

	public function showDate()
	{
		$hi = Session::get('key');
		$gago = Destination::where('destination_id', $hi)->get();
		$reservations = ReservationDate::all();

		return view('customermodule.user.reservation.selectReservationDate', compact('gago', 'reservations'));
	}

	public function storeRequest(Request $request, ReservationDate $reservation)
	{
		$slot = $reservation->number_of_slots;
		$quantity = $request->quantity;
		if($quantity <= $slot)
		{
			$newSlot = $reservation->number_of_slots - $request->quantity;
			$destination = Destination::where('destination_id', Session::get('key'))->get()->first();

			$this->validate(request(), [
				'contactNumber' => 'bail|numeric|required',
				'quantity' => 'bail|numeric|required',
			]);
			Reservation::create([
				'user_id' => auth()->user()->id,
				'date_id' => $reservation->id,
				'destination_name' => $destination->destination_name,
				'name' => auth()->user()->full_name,
				'contact_number' => $request->contactNumber,
				'ticket_quantity' => $quantity,
				'type' => 'Online',
			]);

			$reservation->update([
				'number_of_slots' => $newSlot,
			]);

		    return redirect('/home/reservation/show-reservations')->with('success', 'Successfully created a reservation.');

	
		}
		else
		{
			return back()->withErrors('There are not enough slots for '.$quantity.' persons.');
		}
	}

    // public function storeReservation(CustomerReservationRequest $request)
    // {
    // 	$fullName = null;
    // 	if(Auth::user()->middle_name == null){
    // 		$fullName = Auth::user()->first_name . " " . Auth::user()->last_name;
    // 	}else{
    // 		$fullName = Auth::user()->first_name . " " . Auth::user()->middle_name . " " . Auth::user()->last_name;
    // 	}

    // 	$seat = $request->numberOfSeats;
    //     $destinationReq = $request->destination;
    //     $findDest = Destination::all();

    //     foreach ($findDest->where('destination_id', $destinationReq) as $find) {
    //         $findAmount = $find->amount;
    //     }
    //     $total = $findAmount*$seat;

    // 	if($request->message == null){
    // 		Reservation::create([
    // 			"user_id" => Auth::id(),
    // 			"destination_id" => $request->destination,
    // 			"name" => $fullName,
    // 			"departure_date" => $request->date,
    // 			"departure_time" => $request->time,
    // 			"number_of_seats" => $request->numberOfSeats,
    // 			"contact_number" => $request->contactNumber,
    // 			"status" => "Pending",
    // 			"amount" => $total,
    // 			"type" => "Online",
    // 			"comments" => $request->message,
    // 		]);
    // 	}else{
    // 		Reservation::create([
    // 			"user_id" => Auth::id(),
    // 			"destination_id" => $request->destination,
    // 			"name" => $fullName,
    // 			"departure_date" => $request->date,
    // 			"departure_time" => $request->time,
    // 			"number_of_seats" => $request->numberOfSeats,
    // 			"contact_number" => $request->contactNumber,
    // 			"status" => "Pending",
    // 			"amount" => $total,
    // 			"type" => "Online",
    // 			"comments" => $request->message,
    // 		]);
    // 	}

    // 	return redirect(route('customermodule.user.transactions.customerTransactions'))->with('success', 'Successfully made a Reservation');
    // }
}
