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
        $mainTerminal = Destination::where('is_main_terminal', true)->first()->destination_name;

        if($trip->origin == $mainTerminal){

          $transaction = Transaction::where('trip_id',$trip->trip_id)
            ->selectRaw('COUNT(amount_paid) as ampd, origin, destination, amount_paid')
            ->groupBy('amount_paid')->get();
          $destinationCount = Transaction::where('trip_id',$trip->trip_id)
            ->selectRaw('COUNT(destination) as descount, origin, destination, amount_paid')
            ->groupBy('destination')->get();

          $numPassCountArr = null;
          $tempArr = null;
          $finalArr = null;
          foreach($destinationCount as $desKey => $desValues){

            $tempArr[$desValues->destination] = array();
          }
          //dd($tempArr);
          foreach($transaction  as $transkeys => $transvalues){
            //echo $transvalues->ampd . ' ' . $transvalues->origin . ' ' . $transvalues->destination . ' ' . $transvalues->amount_paid . '<br/>';
            $test1 = Ticket::where('ticket_number', 'like', '%' . $transvalues->destination  . '%')
              ->where('fare', $transvalues->amount_paid)->first()->type ?? null;
            if($test1 == "Regular"){
              $numPassCountArr[$transkeys] = array(
                $transvalues->destination => $transvalues->ampd
              );
            }else if($test1 == "Discount"){
              $numPassCountArr[$transkeys] = array(
                $transvalues->destination => $transvalues->ampd
              );
            }
          }

          foreach($tempArr as $tempArrKeys => $tempArrValues){
            foreach($numPassCountArr as $numPassKeys => $numPassInnerValues){
              foreach($numPassInnerValues as $keys => $values){
                if($keys == $tempArrKeys){
                  array_push($tempArr[$tempArrKeys], $values);
                }
              }

            }
          }

          $driverShare = 0;
          foreach($transaction  as $transkeys => $transvalues){
            $driverShare += $transvalues->ampd * $transvalues->amount_paid;
          }

          $driverShare = $driverShare - ($trip->total_booking_fee + $trip->community_fund + $trip->SOP);

          return view('trips.viewTrip', compact('tempArr', 'trip', 'driverShare'));

        }else{

          $transaction = Transaction::where('trip_id', $trip->trip_id)
            ->selectRaw('COUNT(amount_paid) as ampd, origin, amount_paid')
            ->groupBy('amount_paid')->get();
          //dd($transaction);
          $mainRegCount = 0;
          $mainDisCount = 0;
          $stRegCount = 0;
          $stDisCount = 0;

          $numPassCountArr = array_fill_keys(
            array('mainTerminalRegular', 'mainTerminalDiscount', 'shortTripRegular', 'shortTripDiscount'), ''
          );
          $originArray = null;

          $driverShare = 0;

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
                if($trans->amount_paid == $test2->short_trip_fare){
                  $stRegCount++;
                }else if($trans->amount_paid == $test2->short_trip_fare_discount){
                  $stDisCount++;
                }
              }
            }

            $driverShare += $trans->ampd * $trans->amount_paid;
          }

          $numPassCountArr['mainTerminalRegular'] = $mainRegCount;
          $numPassCountArr['mainTerminalDiscount'] = $mainDisCount;
          $numPassCountArr['shortTripRegular'] = $stRegCount;
          $numPassCountArr['shortTripDiscount'] = $stDisCount;

          $driverShare = $driverShare - ($trip->total_booking_fee + $trip->community_fund);

          return view('trips.viewTripUp', compact('numPassCountArr', 'trip', 'driverShare'));
        }

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
