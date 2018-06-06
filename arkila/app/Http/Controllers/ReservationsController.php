<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Reservation;
use App\ReservationDate;
use App\Ledger;
use App\BookingRules;
use App\Destination;
use App\Ticket;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Session;
use Validator;

class ReservationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('walkin-reservation', ['only' => ['show','create', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $destinations = Destination::allTerminal()->get();
        $main = Destination::mainTerminal()->get()->first();
        $reservations = ReservationDate::all();
        $rule = $this->reservationRules();

        return view('reservations.index', compact('discounts','reservations','main', 'destinations', 'rule'));
    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ReservationDate $reservation)
    {
        Session::put('id',$reservation->id);
        $requests = Reservation::where('date_id', $reservation->id)
        ->where(function($q){
            $q->where('status', 'PAID')
            ->orWhere('status', 'UNPAID')
            ->orWhere([['status', 'CANCELLED'], ['is_refundable', true]]);
        })->get();
        
        return view('reservations.show', compact('reservation', 'requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rule = $this->reservationRules();
        if($rule) {
            $destinations = Destination::allTerminal()->get();
            return view('reservations.create', compact('destinations'));            
        } else {
            return redirect(route('reservations.index'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReservationRequest $request)
    {
        $dateCarbon = new Carbon(request('date'));
        $date = $dateCarbon->format('Y-m-d');
        $timeCarbon = new Carbon(request('time'));
        $time = $timeCarbon->format('H:i:s');

        ReservationDate::create([
            'reservation_date' => $date,
            'departure_time' => $time,
            'destination_terminal' => $request->destination,
            'number_of_slots' => $request->slot,
        ]);
        return redirect('/home/reservations/')->with('success', 'You have created a reservation date successfully');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReservationDate $reservation)
    {
        $this->validate(request(), [
            "openBtn" => [
                Rule::in(['OPEN'])
              ],
            "closeBtn" => [
                Rule::in(['CLOSE'])
              ],              
        ]);

        if($request->status == 'OPEN')
        {
            $reservation->update([
                'status' => 'OPEN',
            ]);

            return back()->with('success', 'Reservation date of '.$reservation->reservation_date->formatLocalized('%d %B %Y').' is now open for requests.');

        }
        elseif($request->status == 'CLOSED')
        {
            $reservation->update([
                'status' => 'CLOSED',
            ]); 

            return back()->with('success', 'Reservation date of '.$reservation->reservation_date->formatLocalized('%d %B %Y').' is now closed.');
           
        }
        else
        {
        	if($reservation->transaction == null){
        		$countReservedSlots = 0;
        	} else {
				 $countReservedSlots = $reservation->transaction->where('date_id', $reservation->id)
	            ->where(function($q){
	                $q->where('status', 'PAID')
	                ->orWhere('status', 'UNPAID')
	                ->orWhere('status', 'TICKET ON HAND');
	            })->count();
        	}


            if($countReservedSlots == 0 && $reservation->status == 'CLOSED')
            {
                $reservation->delete();
                return back()->with('success', 'Reservation date '.$reservation->reservation_date.' is successfully deleted.');
            }
            else
            {
                return back()->withErrors('Cannot delete reservation date of '.$reservation->reservation_date->formatLocalized('%d %B %Y').' because there are still pending requests.');
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(Reservation $reservation)
    // {
    //     //
    //     $reservation->delete();
    //     return back()->with('message', 'Successfully Deleted');
    // }


    public function walkInReservation($id)
    {  
        $rule = $this->reservationRules();

        if($rule) {
            $dateId = Session::get('id');
            $destinations = Destination::allTerminal()->where('destination_id', $id)->get()->first();
            $main = Destination::mainTerminal()->get()->first();
            $date = ReservationDate::where('id', $dateId)->get()->first();
            return view('reservations.createWalkIn', compact('destinations', 'id', 'main', 'date'));            
        } else {
            return redirect(route('reservations.index'));
        }
    }

    public function storeWalkIn(Request $request)
    {
        $dateId = Session::get('id');
        $dates = ReservationDate::where('id', $dateId)->get()->first();
        $quantity = $request->quantity;
        
        if($quantity <= $dates->number_of_slots)
        {
            $this->validate(request(), [
                'destination' => 'required|numeric',
                'name' => 'required|max:100',
                'contactNumber' => 'bail|numeric|required',
                'quantity' => 'bail|numeric|required|min:1|max:2',
            ]);
            $name = ucwords(strtolower($request->name));
            $codes = Reservation::all();
            $newCode = bin2hex(openssl_random_pseudo_bytes(5));
            $refundCode = bin2hex(openssl_random_pseudo_bytes(4));

            foreach ($codes as $code)
            {
                $allRefundCodes = $code->refund_code;
    
                do
                {
                    $refundCode = bin2hex(openssl_random_pseudo_bytes(4));
    
                } while ($refundCode == $allRefundCodes);
            }

            foreach ($codes as $code)
            {
                $allCodes = $code->rsrv_code;
    
                do
                {
                    $newCode =  bin2hex(openssl_random_pseudo_bytes(5));
    
                } while ($newCode == $allCodes);
            }
            $rule = $this->reservationRules();
            $ticket = Ticket::where('destination_id', $request->destination)->get()->first();
            $toBePaid = ($ticket->fare * $quantity) + $rule->reservation_fee;
            $time = explode(':', $dates->departure_time);
            $dateOfDeparture = $dates->reservation_date;
            $expiryDate = $dateOfDeparture->setTime($time[0], $time[1], $time[2]);

    
            $destination = Destination::where('destination_id', $request->destination)->get()->first();
    
            Reservation::create([
                'date_id' => $dateId,
                'destination_name' => $destination->destination_name,
                'rsrv_code' => 'RV'.$newCode,
                'refund_code' => $refundCode,
                'fare' => $toBePaid,
                'name' => $name,
                'is_refundable' => true,
                'contact_number' => $request->contactNumber,
                'expiry_date' => $expiryDate,
                'date_paid' => Carbon::now(),
                'ticket_quantity' => $quantity,
                'type' => 'Walk-in',
                'status' => 'Paid',
            ]);

            Ledger::create([
                'description' => 'Reservation Fee',
                'amount' => $rule->reservation_fee,
                'type' => 'Revenue',
            ]);

            $newNumTicket = $dates->number_of_slots - $quantity;

            $dates->update([
                'number_of_slots' => $newNumTicket,
            ]);

            return redirect('/home/reservations/'. $dateId)->with('success', 'Succesfully created reservation for '. $name);
        }
        else
        {
            return back()->withErrors('There are not enough slots for '.$quantity.' persons.');
        }
    }

    public function refund(Request $request, Reservation $reservation)
    {
        $this->validate(request(), [
            'refundCode' => 'required',
        ]);
        $rule = $this->reservationRules();
        $time = explode(':', $reservation->reservationDate->departure_time);
        if($reservation->status == 'CANCELLED' && $reservation->is_refundable == true) {
            $limitDate = $reservation->updated_at->addDays($rule->refund_expiry)->setTime($time[0], $time[1], $time[2]);
        } else {
            $limitDate = $reservation->reservationDate->reservation_date->subDays(1)->setTime($time[0], $time[1], $time[2]);

        }

        if($limitDate->gt(Carbon::now())) {
            if($request->refundCode == $reservation->refund_code)
            {
                $reservation->update([
                    'status' => 'REFUNDED',
                    'refund_code' => null, 
                    'is_refundable' => false,
                ]);
                $newSlot = $reservation->ticket_quantity + $reservation->reservationDate->number_of_slots;
                $reservation->reservationDate->update([
                    'number_of_slots' => $newSlot,
                ]);

                $reservation->update([
                    'returned_slot' => true,
                ]);
                return redirect(route('reservations.show', $reservation->reservationDate->id))->with('success', 'The reservation had been successfully refunded.');
            } else {
                return back()->withErrors('Refund code does not match.');
            }
        } else {
            return back()->withErrors('Reservation can not be refunded. It has exceeded the given expiration date.');            
       }
    }

    public function payment(Request $request, Reservation $reservation)
    {
            $rule = $this->reservationRules();
            $time = explode(':', $reservation->reservationDate->departure_time);
            $dateOfDeparture = $reservation->reservationDate->reservation_date;
            $expiry = $dateOfDeparture->setTime($time[0], $time[1], $time[2]);
            $refundCode = bin2hex(openssl_random_pseudo_bytes(4));

            $reservation->update([
                'status' => 'PAID',
                'refund_code' => $refundCode,
                'date_paid' => Carbon::now(),
                'expiry_date' => $expiry,
                'is_refundable' => true,
            ]);

            Ledger::create([
                'description' => 'Reservation Fee',
                'amount' => $rule->fee,
                'type' => 'Revenue',
            ]);

            return back()->with('success', 'The reservation has been paid.');
    }

    public function showReservation(Reservation $reservation)
    {
        $rules = $this->reservationRules();
        return view('reservations.showReservation', compact('reservation', 'rules'));
    }

    public function reservationRules()
    {
        return BookingRules::where('description', 'Reservation')->get()->first();;
    }

}
