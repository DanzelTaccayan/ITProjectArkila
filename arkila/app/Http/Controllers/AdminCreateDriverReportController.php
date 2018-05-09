<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminCreateDriverReportRequest;
use App\Http\Controllers\Controller;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use Carbon\Carbon;
use App\Fee;
use App\Destination;
use App\Transaction;
use App\Terminal;
use App\Ledger;
use App\Member;
use App\Ticket;
use App\Trip;
use App\User;
use App\Van;

class AdminCreateDriverReportController extends Controller
{
  public function chooseTerminal()
  {
    $terminals = Destination::where('is_terminal', true)->get();
    $superAdmin = User::where('user_type', 'Super-Admin')->first();
    $superAdminTerminal = Destination::where('is_main_terminal', true)->first();


    return view('trips.chooseDestination',compact('terminals', 'superAdminTerminal'));
  }

  public function createReport(Destination $terminals)
  {
    $superAdminTerminal = Destination::where('is_main_terminal', true)->first();
    if($terminals->destination_id == $superAdminTerminal->destination_id){
  		$destinations = $terminals->routeFromDestination;
 	  }
    $origins = Destination::where('is_terminal', true)->where('is_main_terminal', false)->get();
    $driverAndOperators = Member::where('role', 'Operator')->orWhere('role', 'Driver')->get();
    $plate_numbers = Van::all();
    $member = Member::where('user_id', Auth::id())->first();

    return view('trips.createReport', compact('origins','terminals', 'destinations', 'fad', 'member', 'driverAndOperators', 'plate_numbers'));
  }

  public function storeReport(Destination $terminals)
  {
    $destinationArr = request('destination');
    $numOfPassengers = request('qty');
    $numofdiscpass = request('disqty');

    $ticketArr = null;

      for($i = 0; $i < count($numOfPassengers); $i++){
        if(!($numOfPassengers[$i] == null)){
          $ticketArr[$i] =array($destinationArr[$i] => array($numOfPassengers[$i] => $numofdiscpass[$i]));
        }else{
          continue;
        }
      }
      //$ticketArr = array_merge($desArr, $numPass, $numDis);

    $transaction_array = array_values($ticketArr);
    foreach($transaction_array as $index => $index_values){
      foreach($index_values as $destinationid => $numofpassenger_values){
        foreach($numofpassenger_values as $numofpassenger => $numofpassenger_discount){
          $destination_name = Destination::find($destinationid);
          //echo $destination_name->destination_name . ' ' . $numofpassenger . ' ' . $numofpassenger_discount . '<br/>' ;
          for($i = 1; $i <= $numofpassenger; $i++){
            if($numofpassenger_discount > 0){
              $amountpaid = Ticket::where('destination_id', $destinationid)->where('type','Discount')->first()->fare;
            }else{
              $amountpaid = Ticket::where('destination_id', $destinationid)->where('type','Regular')->first()->fare;
            }

            echo $destination_name->destination_name . ' ' . $amountpaid . '<br/>' ;

            $numofpassenger_discount--;
          }
        }
      }
    }

  //  	$totalPassengers = $request->totalPassengers;
  //   $totalBookingFee = $terminals->booking_fee * $totalPassengers;
  //   $totalPassenger = (float)$request->totalPassengers;
  //
  //   $cf = Fee::where('description', 'Community Fund')->first()->description;
  //   $sop = Fee::where('description', 'SOP')->first()->description;
  //
  //   $user = new User;
  //
  //   $driver_id = $request->driverAndOperator;
  //
  //   $mainterminal = Destination::where('is_main_terminal', true)->first();
  //   $memdriver = Member::find($driver_id);
  //   $vanid = $memdriver->van->first()->van_id !== null ? $memdriver->van->first()->van_id : null;
  //
  //   $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
  //   $timeDepartedFormat = $timeDeparted->format('H:i:s');
  //   $dateDeparted = $request->dateDeparted;
  //
  //   $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first()->destination_id;
  //   $destination = $terminals->destination_id == $mainTerminal ? $request->origin : $mainTerminal;
  //   $destinationname = Destination::find($destination);
  //
  //   if($terminals->destination_id == $mainTerminal){
  //     if($totalPassengers >=  10){
  //       $trip = Trip::create([
  //          'driver_id' => $driver_id,
  //          'van_id' => $vanid,
  //          'destination' => $destinationname->destination_name,
  //          'origin' => $terminals->destination_name,
  //          'total_passengers' => $totalPassengers,
  //          'total_booking_fee' => $totalBookingFee,
  //          'community_fund' => $cf,
  //          'SOP' => $sop,
  //          'date_departed' => $request->dateDeparted,
  //          'time_departed' => $timeDepartedFormat,
  //          'report_status' => 'Accepted',
  //       ]);
  //
  //      $insertLegderQuery = array(
  //         array('description' => 'SOP', 'amount' => $trip->SOP, 'type' => 'Revenue'),
  //         array('description' => 'Booking Fee', 'amount' => $trip->total_booking_fee, 'type' => 'Revenue'),
  //       );
  //
  //       Ledger::insert($insertLegderQuery);
  //
  //    }else if($totalPassengers <  10){
  //       $trip = Trip::create([
  //          'driver_id' => $driver_id,
  //          'van_id' => $vanid,
  //          'destination' => $destinationname->destination_name,
  //          'origin' => $terminals->destination_name,
  //          'total_passengers' => $totalPassengers,
  //          'total_booking_fee' => $totalBookingFee,
  //          'community_fund' => $cf,
  //          'SOP' => $sop,
  //          'date_departed' => $request->dateDeparted,
  //          'time_departed' => $timeDepartedFormat,
  //          'report_status' => 'Accepted',
  //        ]);
  //
  //       Ledger::create([
  //           'description' => 'Booking Fee',
  //           'amount' => $trip->total_booking_fee,
  //           'type' => 'Revenue',
  //         ]);
  //
  //    }
  //    //NEW
  //    $destinationArr = request('destination');
  //    $numOfPassengers = request('qty');
  //    $numofdiscpass = request('disqty');
  //
  //    $ticketArr = null;
  //
  //      for($i = 0; $i < count($numOfPassengers); $i++){
  //        if(!($numOfPassengers[$i] == null)){
  //          $ticketArr[$i] =array($destinationArr[$i] => array($numOfPassengers[$i] => $numofdiscpass[$i]));
  //        }else{
  //          continue;
  //        }
  //      }
  //      //$ticketArr = array_merge($desArr, $numPass, $numDis);
  //
  //      $ts = array_values($ticketArr);
  //      dd($ts);
  //    //OLD
  //   $destinationArr = request('destination');
  //   $numOfPassengers = request('qty');
  //   $discountArr = request('discountId');
  //   $numOfDiscount = request('numberOfDiscount');
  //   $ticketArr = null;
  //   $discountTransactionArr = null;
  //   $numofdiscpass = request('disqty');
  //
  //     for($i = 0; $i < count($numOfPassengers); $i++){
  //       if(!($numOfPassengers[$i] == null)){
  //         $ticketArr[$i] = array($destinationArr[$i] => $numOfPassengers[$i]);
  //       }else{
  //         continue;
  //       }
  //     }
  //
  //   $tripId = Trip::latest()->select('trip_id')->first();
  //   $insertTicketArr = array_values($ticketArr);
  //
  //     foreach($insertTicketArr as $ticketKey => $innerTicketArrays){
  //       foreach($innerTicketArrays as $innerTicketKeys => $innerTicketValues){
  //
  //         for($i = 1; $i <= $innerTicketValues; $i++){
  //           Transaction::create([
  //             "destination_id" => $innerTicketKeys,
  //             'terminal_id' => $terminals->terminal_id,
  //             "trip_id" => $tripId->trip_id,
  //             "status" => 'Departed',
  //           ]);
  //         }
  //       }
  //     }
  //
  //     if($numOfDiscount != null){
  //       $discountTransactionArr = array_combine($discountArr, $numOfDiscount);
  //       $latestTrip = Trip::latest()->first();
  //       $transaction = Transaction::orderBy('created_at', 'desc')->get();
  //       $updateQueryCount = $totalPassengers;
  //
  //      $counter = 0;
  //      foreach($discountTransactionArr as $key => $value){
  //          $numOfDiscount = $value;
  //          if($numOfDiscount == null){
  //            //echo $numOfDiscount . "hi <br/>";
  //            continue;
  //          }else{
  //
  //            while($numOfDiscount != 0){
  //              $check = $transaction[$counter]->update([
  //                "fad_id" => $key,
  //              ]);
  //              $counter++;
  //              $numOfDiscount--;
  //            }
  //          }
  //      }
  //     }
  //   }else{
  //     if($totalPassengers >=  10){
  //        $trip =Trip::create([
  //         'driver_id' => $driver_id,
  //         'van_id' => $van_id,
  //         'destination' => $mainterminal->destination_name,
  //         'origin' => $terminals->destination_name,
  //         'total_passengers' => $totalPassengers,
  //         'total_booking_fee' => $totalbookingfee,
  //         'community_fund' => $cf->amount,
  //         'report_status' => 'Pending',
  //         'date_departed' => $request->dateDeparted,
  //         'time_departed' => $timeDepartedFormat,
  //       ]);
  //     }else if($totalPassengers <  10){
  //        $trip = Trip::create([
  //          'driver_id' => $driver_id,
  //          'van_id' => $van_id,
  //          'destination' => $mainterminal->destination_name,
  //          'origin' => $terminals->destination_name,
  //          'total_passengers' => $totalPassengers,
  //          'total_booking_fee' => $totalbookingfee,
  //          'report_status' => 'Pending',
  //          'date_departed' => $request->dateDeparted,
  //          'time_departed' => $timeDepartedFormat,
  //        ]);
  //     }
  //
  //     $numberofmainpassengers = $request->numPassMain;
  //     $numberofmaindiscount = $request->numDisMain;
  //     $numberofstpassengers = $request->numPassST;
  //     $numberofstdiscount = $request->numDisST;
  //     $shortTripFare = $terminal->short_trip_fare;
  //     $shortTripDiscountFare = $terminal->short_trip_fare_discount;
  //
  //     if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
  //        ($numberofstpassengers !== null && $numberofstdiscount !== null)){
  //
  //           for($i = 0; $i < $numberofmainpassengers; $i++){
  //              if($numberofmaindiscount > 0){
  //                $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
  //                $amountpaid = $terminalfare;
  //              }else{
  //                $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
  //                $amountpaid = $terminalfare;
  //              }
  //
  //              Transaction::create([
  //                "trip_id" => $trip->trip_id,
  //                "destination" => $mainterminal->destination_name,
  //                "origin" => $terminal->destination_name,
  //                "amount_paid" => $amountpaid,
  //                "status" => "Pending",
  //              ]);
  //
  //              $numberofmaindiscount--;
  //           }
  //
  //           for($i = 0; $i < $numberofstpassengers; $i++){
  //              if($numberofstdiscount > 0){
  //                $amountpaid = $shortTripDiscountFare;
  //              }else{
  //                $amountpaid = $shortTripFare;
  //              }
  //
  //              Transaction::create([
  //                "trip_id" => $trip->trip_id,
  //                "destination" => $mainterminal->destination_name,
  //                "origin" => $terminal->destination_name,
  //                "amount_paid" => $amountpaid,
  //                "status" => "Pending",
  //              ]);
  //
  //              $numberofstdiscount--;
  //           }
  //
  //     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
  //        ($numberofstpassengers !== null && $numberofstdiscount == null)){
  //
  //        $amountpaid = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;;
  //
  //        for($i = 0; $i < $numberofmainpassengers; $i++){
  //          Transaction::create([
  //            "trip_id" => $trip->trip_id,
  //            "destination" => $mainterminal->destination_name,
  //            "origin" => $terminal->destination_name,
  //            "amount_paid" => $amountpaid,
  //            "status" => "Pending",
  //          ]);
  //        }
  //
  //        for($i = 0; $i < $numberofstpassengers; $i++){
  //          Transaction::create([
  //            "trip_id" => $trip->trip_id,
  //            "destination" => $mainterminal->destination_name,
  //            "origin" => $terminal->destination_name,
  //            "amount_paid" => $shortTripFare,
  //            "status" => "Pending",
  //          ]);
  //        }
  //
  //     }else if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
  //        ($numberofstpassengers == null && $numberofstdiscount == null)){
  //
  //        for($i = 0; $i < $numberofmainpassengers; $i++){
  //          if($numberofmaindiscount > 0){
  //            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
  //            $amountpaid = $terminalfare;
  //          }else{
  //            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
  //            $amountpaid = $terminalfare;
  //          }
  //
  //          Transaction::create([
  //            "trip_id" => $trip->trip_id,
  //            "destination" => $mainterminal->destination_name,
  //            "origin" => $terminal->destination_name,
  //            "amount_paid" => $amountpaid,
  //            "status" => "Pending",
  //          ]);
  //
  //          $numberofmaindiscount--;
  //        }
  //
  //     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
  //        ($numberofstpassengers == null && $numberofstdiscount == null)){
  //        $amountpaid = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;;
  //
  //        for($i = 0; $i < $numberofmainpassengers; $i++){
  //          Transaction::create([
  //            "trip_id" => $trip->trip_id,
  //            "destination" => $mainterminal->destination_name,
  //            "origin" => $terminal->destination_name,
  //            "amount_paid" => $amountpaid,
  //            "status" => "Pending",
  //          ]);
  //        }
  //
  //     }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
  //        ($numberofstpassengers !== null && $numberofstdiscount !== null)){
  //
  //        for($i = 0; $i < $numberofstpassengers; $i++){
  //              if($numberofstdiscount > 0){
  //                $amountpaid = $shortTripDiscountFare;
  //              }else{
  //                $amountpaid = $shortTripFare;
  //              }
  //
  //              Transaction::create([
  //                "trip_id" => $trip->trip_id,
  //                "destination" => $mainterminal->destination_name,
  //                "origin" => $terminal->destination_name,
  //                "amount_paid" => $amountpaid,
  //                "status" => "Pending",
  //              ]);
  //
  //              $numberofstdiscount--;
  //           }
  //
  //     }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
  //        ($numberofstpassengers !== null && $numberofstdiscount == null)){
  //
  //        for($i = 0; $i < $numberofstpassengers; $i++){
  //          Transaction::create([
  //            "trip_id" => $trip->trip_id,
  //            "destination" => $mainterminal->destination_name,
  //            "origin" => $terminal->destination_name,
  //            "amount_paid" => $shortTripFare,
  //            "status" => "Pending",
  //          ]);
  //        }
  //     }
  //   }
  // return redirect('home/trip-log')->with('success', 'Report created successfully!');
  }
}
