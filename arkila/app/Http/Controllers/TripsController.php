<?php

namespace App\Http\Controllers;

use Auth;
use App\Trip;
use App\Ticket;
use App\Van;
use App\Member;
use App\User;
use App\Terminal;
use App\Transaction;
use App\Destination;
use Carbon\Carbon;
use App\Notifications\TripReportsDriverNotification;
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
            ->selectRaw('COUNT(amount_paid) as ampd, origin, is_short_trip, transaction_ticket_type,amount_paid')
            ->groupBy('amount_paid')->get();
          
          $mainRegCount = 0;
          $mainDisCount = 0;
          $stRegCount = 0;
          $stDisCount = 0;

          $numPassCountArr = array();
          $originArray = null;

          // foreach($transaction as $tran){
          //   echo $tran->ampd . ' ' . $tran->origin . ' ' . $tran->is_short_trip . ' ' . $tran->amount_paid . '<br/>';
          // }
    
          $driverShare = 0;
          $totalFare = 0;
          foreach($transaction as $trans){
            if($trans->is_short_trip == false){
              for($i = 0; $i < $trans->ampd; $i++){
                if($trans->transaction_ticket_type == "Regular"){
                  $mainRegCount++;
                }else if($trans->transaction_ticket_type == "Discount"){
                  $mainDisCount++;
                }
              }
            }

            if($trans->is_short_trip == true){
              for($i = 0; $i < $trans->ampd; $i++){
                if($trans->transaction_ticket_type == "Regular"){
                  $stRegCount++;
                }else if($trans->transaction_ticket_type == "Discount"){
                  $stDisCount++;
                }
              }
            }

            $totalFare += $trans->ampd * $trans->amount_paid;
          }

          $numPassCountArr[0] = $mainRegCount;
          $numPassCountArr[1] = $mainDisCount;
          $numPassCountArr[2] = $stRegCount;
          $numPassCountArr[3] = $stDisCount;

          $totalPassenger = 0;
          $totalDiscountedPassenger = 0;
          //dd($numPassCountArr);
          foreach($numPassCountArr as $keys => $value){
            if($keys % 2 == 0){
              $totalPassenger += $value;
            }else{
              continue;
            }
          }

          foreach($numPassCountArr as $keys => $value){
            if($keys % 2 != 0){
              $totalDiscountedPassenger += $value;
            }else{
              continue;
            }
          }
          $driverShare = $totalFare - ($trip->total_booking_fee + $trip->community_fund);
          $officeShare = $totalFare - $driverShare;

      return view('trips.viewReport', compact('numPassCountArr','trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger', 'totalDiscountedPassenger'));
    }

    public function acceptReport(Trip $trip)
    {
        $trip->update([
            "report_status" => 'Accepted',
        ]);
         
        $trip->transactions()->update(['status' => 'Accepted']);
        
        $message = "Trip " . $trip->trip_id . " successfully accepted";
        return redirect(route('trips.tripLog'))->with('success', $message);
    }

    public function declineReport(Trip $trip)
    {
        $trip->update([
            "report_status" => 'Declined',
        ]);
        
        $trip->transactions()->update(['status' => 'Declined']);
        $message = "Trip " . $trip->trip_id . " successfully declined";
        return redirect(route('trips.driverReport'))->with('success', $message);
    }

    public function viewTripLog(Trip $trip)
    {
        $mainTerminal = Destination::where('is_main_terminal', true)->first()->destination_name;
        $transactions = $trip->transactions->where('ticket_name', '!=', null)->count() > 0 ? true : false;
        
        if($trip->origin == $mainTerminal && $transactions == false){

          $transaction = Transaction::where('trip_id',$trip->trip_id)
            ->selectRaw('COUNT(amount_paid) as ampd, origin, destination, amount_paid, transaction_ticket_type')
            ->groupBy('amount_paid', 'destination')
            ->orderBy('amount_paid', 'ampd','DESC')
            ->get();
       
          $destinationCount = Transaction::where('trip_id',$trip->trip_id)
            ->selectRaw('COUNT(destination) as descount, origin, destination, amount_paid')
            ->groupBy('destination')->get();

          $numPassCountArr = null;
          $tempArr = null;

          $finalArr = null;
          foreach($destinationCount as $desKey => $desValues){
              $tempArr[$desValues->destination] = array_fill_keys(
                array('Regular', 'Discount'), ''
              );
          }

          foreach($transaction  as $transkeys => $transvalues){
            if($transvalues->transaction_ticket_type == "Regular"){
              $tempArr[$transvalues->destination]['Regular'] = $transvalues->ampd; 
            }else{
              $tempArr[$transvalues->destination]['Regular'] = 0;
            }

            if($transvalues->transaction_ticket_type == "Discount"){
              $tempArr[$transvalues->destination]['Discount'] = $transvalues->ampd;
            }else{
              $tempArr[$transvalues->destination]['Discount'] = 0;  
            } 
          }

          $totalPassenger = 0;
          $totalDiscountedPassenger = 0;
          foreach($tempArr as $destinationKey => $numOfPassValue){
            foreach($numOfPassValue as $type => $num){
              if($type == 'Regular'){
                $totalPassenger = $totalPassenger + $num;
              }else if($type == 'Discount'){
                $totalDiscountedPassenger = $totalDiscountedPassenger + $num;
              }
            }
          }

          $driverShare = 0;
          $totalFare = 0;
          foreach($transaction  as $transkeys => $transvalues){
            $totalFare += $transvalues->ampd * $transvalues->amount_paid;
          }

          $driverShare = $totalFare - ($trip->total_booking_fee + $trip->community_fund + $trip->SOP);
          $officeShare = $totalFare - $driverShare;
          
          return view('trips.viewTrip', compact('tempArr', 'trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger','totalDiscountedPassenger'));

        }else if($trip->origin == $mainTerminal && $transactions == true){
            $discount = Transaction::where('trip_id',$trip->trip_id)
              ->selectRaw("COUNT(SUBSTRING_INDEX(ticket_name, '-', '1')) as counts, SUBSTRING_INDEX(ticket_name, '-', '1') as tickets, transaction_ticket_type")
              ->where('transaction_ticket_type', 'Discount')
              ->groupBy('tickets')
              ->get();
            
            $regular = Transaction::where('trip_id',$trip->trip_id)
              ->selectRaw("COUNT(SUBSTRING_INDEX(ticket_name, '-', '1')) as counts, SUBSTRING_INDEX(ticket_name, '-', '1') as tickets, transaction_ticket_type")
              ->where('transaction_ticket_type', 'Regular')
              ->groupBy('tickets')
              ->get();

            $transactions = Transaction::where('trip_id',$trip->trip_id)
              ->selectRaw("COUNT(SUBSTRING_INDEX(ticket_name, '-', '1')) as counts, SUBSTRING_INDEX(ticket_name, '-', '1') as tickets, transaction_ticket_type")
              ->groupBy('tickets')
              ->get();
            
            $totalFares = Transaction::where('trip_id',$trip->trip_id)->get();

            $tempArr = null;

            foreach($transactions as $tranKey => $tranValues){
                $tempArr[$tranValues->tickets] = array_fill_keys(
                  array('Regular', 'Discount'), 0
                );
            }

            foreach($discount as $tran){
              $tempArr[$tran->tickets]['Discount'] = $tran->counts; 
            }  
            
            foreach($regular as $tran){
              $tempArr[$tran->tickets]['Regular'] = $tran->counts;
            }  

            

            $totalPassenger = 0;
            $totalDiscountedPassenger = 0;
            foreach($tempArr as $destinationKey => $numOfPassValue){
              foreach($numOfPassValue as $type => $num){
                if($type == 'Regular'){
                  $totalPassenger = $totalPassenger + $num;
                }else if($type == 'Discount'){
                  $totalDiscountedPassenger = $totalDiscountedPassenger + $num;
                }
              }
            }
            
            $driverShare = 0;
            $totalFare = 0;
            foreach($totalFares  as $tAmount){
              $totalFare += $tAmount->amount_paid;
            }

            $driverShare = $totalFare - ($trip->total_booking_fee + $trip->community_fund + $trip->SOP);
            $officeShare = $totalFare - $driverShare;
          
          return view('trips.viewTrip', compact('tempArr', 'trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger','totalDiscountedPassenger'));
        }else{

          $transaction = Transaction::where('trip_id', $trip->trip_id)
            ->selectRaw('COUNT(amount_paid) as ampd, origin, is_short_trip, transaction_ticket_type,amount_paid')
            ->groupBy('amount_paid')->get();

          $mainRegCount = 0;
          $mainDisCount = 0;
          $stRegCount = 0;
          $stDisCount = 0;

          $numPassCountArr = array();
          $originArray = null;

          $driverShare = 0;
          $totalFare = 0;
          
          foreach($transaction as $trans){
            if($trans->is_short_trip == false){
              for($i = 0; $i < $trans->ampd; $i++){
                if($trans->transaction_ticket_type == "Regular"){
                  $mainRegCount++;
                }else if($trans->transaction_ticket_type == "Discount"){
                  $mainDisCount++;
                }
              }
            }

            if($trans->is_short_trip == true){
              for($i = 0; $i < $trans->ampd; $i++){
                if($trans->transaction_ticket_type == "Regular"){
                  $stRegCount++;
                }else if($trans->transaction_ticket_type == "Discount"){
                  $stDisCount++;
                }
              }
            }

            $totalFare += $trans->ampd * $trans->amount_paid;
          }

          $numPassCountArr[0] = $mainRegCount;
          $numPassCountArr[1] = $mainDisCount;
          $numPassCountArr[2] = $stRegCount;
          $numPassCountArr[3] = $stDisCount;

          $totalPassenger = 0;
          $totalDiscountedPassenger = 0;

          foreach($numPassCountArr as $keys => $value){
            if($keys % 2 == 0){
              $totalPassenger += $value;
            }else{
              continue;
            }
          }

          foreach($numPassCountArr as $keys => $value){
            if($keys % 2 != 0){
              $totalDiscountedPassenger += $value;
            }else{
              continue;
            }
          }
          $driverShare = $totalFare - ($trip->total_booking_fee + $trip->community_fund);
          $officeShare = $totalFare - $driverShare;

          return view('trips.viewTripUp', compact('numPassCountArr','trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger', 'totalDiscountedPassenger'));
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
