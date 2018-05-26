<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Reservation;
use App\ReservationDate;
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
        //
        // $terminals = Terminal::whereNotIn('terminal_id',[auth()->user()->terminal_id])->get();
        $destinations = Destination::allTerminal()->get();
        $main = Destination::mainTerminal()->get()->first();
        $reservations = ReservationDate::all();

        return view('reservations.index', compact('discounts','reservations','main', 'destinations'));
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
            ->orWhere('status', 'UNPAID');
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
        $destinations = Destination::allTerminal()->get();
        return view('reservations.create', compact('destinations'));
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
        $validate = Validator::make($request->all(), [
            "statusBtn" => [
                'required',
                Rule::in(['OPEN', 'CLOSED'])
              ],
          ]);

        if($validate->fails())
        {
            return response()->json(["error" => "Please make sure that your input is valid, you can only open or close an specific reservation date."]);
        }
        else
        {
            $reservation->update([
                'status' => $request->statusBtn,
                ]);
            return response()->json(['success' => 'Reservation marked as '. request('statusBtn'), 'status' => $request->statusBtn]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
        $reservation->delete();
        return back()->with('message', 'Successfully Deleted');
    }


    public function walkInReservation($id)
    {  
        $dateId = Session::get('id');
        $destinations = Destination::allTerminal()->where('destination_id', $id)->get()->first();
        $main = Destination::mainTerminal()->get()->first();
        $date = ReservationDate::where('id', $dateId)->get()->first();
        return view('reservations.createWalkIn', compact('destinations', 'id', 'main', 'date'));
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
            $newCode = bin2hex(openssl_random_pseudo_bytes(8));
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
                    $newCode =  bin2hex(openssl_random_pseudo_bytes(8));
    
                } while ($newCode == $allCodes);
            }
            $ticket = Ticket::where('destination_id', $request->destination)->get()->first();
            $toBePaid = $ticket->fare * $quantity;

            $dateOfDeparture = $dates->reservation_date;
            $setExpiry = $dateOfDeparture->addDays(2)->setTime(17, 00, 00);
            $expiryDate = $setExpiry->setTime(17, 00, 00);

    
            $destination = Destination::where('destination_id', $request->destination)->get()->first();
    
            Reservation::create([
                'date_id' => $dateId,
                'destination_name' => $destination->destination_name,
                'rsrv_code' => $newCode,
                'refund_code' => $refundCode,
                'fare' => $toBePaid,
                'name' => $name,
                'contact_number' => $request->contactNumber,
                'expiry_date' => $expiryDate,
                'date_paid' => Carbon::now(),
                'ticket_quantity' => $quantity,
                'type' => 'Walk-in',
                'status' => 'Paid',
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

        if($request->refundCode == $reservation->refund_code)
        {
            $reservation->update([
                'status' => 'Refunded',
                'refund_code' => null, 
            ]);

            return back()->with('success', 'The reservation had been successfully refunded.');
        }
        else
        {
            return back()->withErrors('Refund code does not match.');
       }
    }

    public function payment(Request $request, Reservation $reservation)
    {
            $dateOfDeparture = $reservation->reservationDate->reservation_date;
            $expiry = $dateOfDeparture->addDays(2)->setTime(17, 00, 00);
            $newExpiry = $expiry->setTime(17, 00, 00);
            $refundCode = bin2hex(openssl_random_pseudo_bytes(4));

            $reservation->update([
                'status' => 'PAID',
                'refund_code' => $refundCode,
                'date_paid' => Carbon::now(),
                'expiry_date' => $newExpiry,
            ]);

            return back()->with('success', 'The reservation has been paid.');
    }

    public function showReservation()
    {
        return view('reservation.showReservation');
    }
}
