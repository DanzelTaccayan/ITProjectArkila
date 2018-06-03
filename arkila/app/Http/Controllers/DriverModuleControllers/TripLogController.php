<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Destination;
use App\Ticket;
use App\Transaction;
use App\Trip;
use App\Member;
use App\User;
class TripLogController extends Controller
{
    public function viewTripLog()
    {
      //$trips = Trip::where('driver_id', Auth::id())->get();
      $tripsMade = Member::where('user_id', Auth::id())->first();
      return view('drivermodule.triplog.driverTripLog', compact('tripsMade'));
    }

    public function viewSpecificTrip(Trip $trip)
    {
      $mainTerminal = Destination::where('is_main_terminal', true)->first()->destination_name;
      $transactions = $trip->transactions->where('ticket_name', '!=', null)->count() > 0 ? true : false;
      
      if($trip->origin == $mainTerminal  && $transactions == false){
        
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

        return view('drivermodule.triplog.driverTripDetails', compact('tempArr', 'trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger','totalDiscountedPassenger'));

      }else if($trip->origin == $mainTerminal && $transactions == true){
        //discount
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
          foreach($transactions  as $transkeys => $transvalues){
            $totalFare += $transvalues->ampd * $transvalues->amount_paid;
          }

          $driverShare = $totalFare - ($trip->total_booking_fee + $trip->community_fund + $trip->SOP);
          $officeShare = $totalFare - $driverShare;
        
        return view('drivermodule.triplog.driverTripDetails', compact('tempArr', 'trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger','totalDiscountedPassenger'));
      }else{

        $transaction = Transaction::where('trip_id', $trip->trip_id)
          ->selectRaw('COUNT(amount_paid) as ampd, origin, amount_paid')
          ->groupBy('amount_paid')->get();
        //dd($transaction);
        $mainRegCount = 0;
        $mainDisCount = 0;
        $stRegCount = 0;
        $stDisCount = 0;

        $numPassCountArr = array();
        $originArray = null;

        $driverShare = 0;
        $totalFare = 0;
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

          $totalFare += $trans->ampd * $trans->amount_paid;
        }

        $numPassCountArr[0] = $mainRegCount;
        $numPassCountArr[1] = $mainDisCount;
        $numPassCountArr[2] = $stRegCount;
        $numPassCountArr[3] = $stDisCount;

        $totalPassenger = array_sum($numPassCountArr);
        $totalDiscountedPassenger = 0;



        foreach($numPassCountArr as $keys => $value){
          if($keys % 2 != 0){
            $totalDiscountedPassenger += $value;
          }else{
            continue;
          }
        }
        $driverShare = $totalFare - ($trip->total_booking_fee + $trip->community_fund);
        $officeShare = $totalFare - $driverShare;

        return view('drivermodule.triplog.driverTripDetailsUp', compact('numPassCountArr','trip', 'driverShare', 'totalFare', 'officeShare', 'totalPassenger', 'totalDiscountedPassenger'));
      }
    }
}
