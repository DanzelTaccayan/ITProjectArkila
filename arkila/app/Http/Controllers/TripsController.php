<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Ticket;
use App\Van;
use App\Member;
use App\User;
use App\Terminal;
use App\Transaction;
use App\Destination;
use Carbon\Carbon;
use PDF;
use Illuminate\Validation\Rule;


class TripsController extends Controller
{


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
      $transaction = Transaction::where('trip_id', $trip->trip_id)
        ->selectRaw('COUNT(amount_paid) as ampd, origin, amount_paid')
        ->groupBy('amount_paid')->get();
      $mainRegCount = 0;
      $mainDisCount = 0;
      $stRegCount = 0;
      $stDisCount = 0;
      $numPassCountArr = array_fill_keys(
        array('mainTerminalRegular', 'mainTerminalDiscount', 'shortTripRegular', 'shortTripDiscount'), ''
      );
      $originArray = null;

      foreach($transaction as $trans){
        //echo $trans . "<br/>";
        $test1 = Ticket::where('ticket_number', 'like', '%' . $trans->origin . '%')
          ->where('fare', $trans->amount_paid)->first() ?? null;
        $test2 = Destination::where('destination_name', 'like', '%' . $trans->origin . '%')
          ->where('short_trip_fare', $trans->amount_paid)
          ->orWhere('short_trip_fare_discount', $trans->amount_paid)->first() ?? null;

        if($test1 !== null){
          for($i = 0; $i < $trans->ampd; $i++){
            if($test1->type == "Regular"){
              $mainRegCount++;
            }else if($test1->type == "Discount"){
              $mainDisCount++;
            }
          }
        }
        if($test2 !== null){
          for($i = 0; $i < $trans->ampd; $i++){
            if($trans->origin && $trans->amount_paid == $test2->short_trip_fare){
              $stRegCount++;
            }else if($trans->amount_paid == $test2->short_trip_fare_discount){
              $stDisCount++;
            }
          }
        }

      }
      $numPassCountArr['mainTerminalRegular'] = $mainRegCount;
      $numPassCountArr['mainTerminalDiscount'] = $mainDisCount;
      $numPassCountArr['shortTripRegular'] = $stRegCount;
      $numPassCountArr['shortTripDiscount'] = $stDisCount;
      //dd($numPassCountArr);
      return view('trips.viewReport', compact('numPassCountArr', 'trip'));
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
