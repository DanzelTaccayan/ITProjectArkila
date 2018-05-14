<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Ticket;
use App\Van;
use App\Member;
use App\User;
use App\Terminal;
use App\Transaction;
use Carbon\Carbon;
use PDF;
use Illuminate\Validation\Rule;


class TripsController extends Controller
{

    public function store(Destination $terminal) {

    }

    public function tripLog()
    {
        $trips = Trip::where('report_status', 'Accepted')->with('van')->get();
        return view('trips.tripLog', compact('trips'));
    }

    public function driverReport()
    {
        $trips = Trip::pending()->with('van')->get();
        return view('trips.driverReport', compact('trips'));
    }

    public function viewReport(Trip $trip)
    {
      $transaction = Transaction::where('trip_id', $trip->trip_id)->groupBy('amount_paid')->get();
      $passAndDisCount = 0;
      foreach($transaction as $trans) {
        echo $trans->transaction_id . ' ' . $trans->amount_paid .'<br/>';
      }
      //return view('trips.viewReport', compact('transaction', 'trip'));
    }

    public function acceptReport(Trip $trip)
    {
        $trip->update([
            "report_status" => 'Accepted',
        ]);

        $message = "Trip " . $trip->trip_id . " successfully accepted";
        return redirect(route('trips.tripLog'))->with('success', $message);
    }

    public function declineReport(Trip $trip)
    {
        $trip->update([
            "report_status" => 'Declined',
        ]);
        $message = "Trip " . $trip->trip_id . " successfully declined";
        return redirect(route('trips.driverReport'))->with('success', $message);
    }

    public function viewTripLog(Trip $trip)
    {
        $destinations = Transaction::join('destination', 'destination.destination_id', '=', 'transaction.destination_id')
        ->join('trip', 'trip.trip_id', '=', 'transaction.trip_id')
        ->where('transaction.trip_id', $trip->trip_id)
        ->selectRaw('transaction.trip_id as tripid, destination.description as destdesc, destination.amount as amount, COUNT(destination.description) as counts')
        ->groupBy(['transaction.trip_id','destination.description'])->get();
        $tickets = Transaction::join('ticket', 'transaction.ticket_id','=','ticket.ticket_id')
        ->where('trip_id',$trip->trip_id)->get();
        foreach($tickets as $ticket){
            if($ticket->type === "Discount"){

            }
        }
        $user = User::where('user_type','Super-admin')->first();
        $superAdmin = $user->terminal;
        return view('trips.viewTrip', compact('destinations', 'trip', 'superAdmin'));
    }

    public function generatePerTrip(Trip $trip)
    {
        $destinations = Transaction::join('destination', 'destination.destination_id', '=', 'transaction.destination_id')->join('trip', 'trip.trip_id', '=', 'transaction.trip_id')->where('transaction.trip_id', $trip->trip_id)->selectRaw('transaction.trip_id as tripid, destination.description as destdesc, destination.amount as amount, COUNT(destination.description) as counts')->groupBy(['transaction.trip_id','destination.description'])->get();
        $user = User::where('user_type','Super-admin')->first();
        $superAdmin = $user->terminal;
        $date = Carbon::now();
        $pdf = PDF::loadView('pdf.perTrip', compact('destinations', 'date', 'trip', 'superAdmin'));
        return $pdf->stream("tripLog.pdf");

    }
}
