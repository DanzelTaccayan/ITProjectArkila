<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReservationRequest;
use App\Reservation;
use App\ReservationDate;
use App\Destination;
use App\Fee;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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

        $reservations = ReservationDate::all();
        $discounts = Fee::all();

        return view('reservations.index', compact('discounts','reservations', 'destinations'));
    }
        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ReservationDate $reservation)
    {
        $requests = Reservation::where('date_id', $reservation->id)->get();
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
        // $seat = $request->seat;
        // $destinationReq = $request->dest;
        // $findDest = Destination::all();

        // if ($findDest->where('description', $destinationReq)->count() > 0) {
        //     foreach ($findDest->where('description', $destinationReq) as $find) {
        //         $findThis = $find->destination_id;
        //         $findAmount = $find->amount;
        //     }
        //     $total = $findAmount*$seat;
        // } else {
        //     return back()->withInput()->withErrors('Invalid Destination!');
        // }

        // $timeRequest = new Carbon(request('time'));
        // $timeFormatted = $timeRequest->format('h:i A');
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
    public function update(Reservation $reservation)
    {
        $this->validate(request(),[
            "click" => [
              'required',
              Rule::in(['Accepted', 'Declined'])
            ],
          ]);

        $reservation->update([

            'status' => request('click'),
        ]);
        session()->flash('message', 'Reservation marked '. request('click'));
        return redirect()->back();
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

    public function find(Request $request){
        $data = Reservation::select('reservation.destination_id', 'destination.description', 'terminal.description as terminal', 'terminal.terminal_id')
        ->join('destination', 'reservation.destination_id', '=', 'destination.destination_id')
        ->join('terminal', 'terminal.terminal_id', '=', 'destination.terminal_id')
        ->where('reservation.id', '=', $request->id)->get();

        return response()->json($data);
    }

    public function walkInReservation()
    {
        return view('reservations.createWalkIn');
    }
}
