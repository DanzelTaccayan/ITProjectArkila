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


    //dd($originDestinationArr);

    // foreach($terminals as $t){
    //   $f = $t->terminalDestination()->groupBy('terminal_destination')->get();
    //   //$b = $f->where();
    //   foreach($f as $fs){
    //     //echo $fs . '<br/>';
    //   }
    // }

    return view('trips.chooseDestination',compact('terminals', 'superAdminTerminal'));
  }

  public function createReport(Destination $terminals, Destination $destination)
  {
    //dd($destination);
    $superAdminTerminal = Destination::where('is_main_terminal', true)->first();
    if($terminals->destination_id == $superAdminTerminal->destination_id){
  		$destinations = $destination->routeFromDestination->groupBy('destination_id');
 	  }
    $origins = Destination::where('is_terminal', true)->where('is_main_terminal', false)->get();
    $driverAndOperators = Member::where('role', 'Operator')->orWhere('role', 'Driver')->get();
    $plate_numbers = Van::all();
    $member = Member::where('user_id', Auth::id())->first();


    return view('trips.createReport', compact('origins','terminals', 'destinations', 'destination', 'member', 'driverAndOperators', 'plate_numbers'));
  }

  public function storeReport(Destination $terminals, Destination $destination, AdminCreateDriverReportRequest $request)
  {
        //dd($request->timeDeparted);
   	$totalPassengers = $request->totalPassengers;
    $totalBookingFee = $terminals->booking_fee * $totalPassengers;
    $totalPassenger = (float)$request->totalPassengers;

    $cf = Fee::where('description', 'Community Fund')->first()->amount;
    $sop = Fee::where('description', 'SOP')->first()->amount;

    $user = new User;

    $driver_id = $request->driverAndOperator;


    $mainterminal = Destination::where('is_main_terminal', true)->first()->destination_name;
    // $memdriver = Member::find($driver_id);
    // $getvanid = $memdriver->van->first()->van_id ?? null;
    $vanid = $request->van_platenumber;

    $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
    $timeDepartedFormat = $timeDeparted->format('H:i:s');
    $dateDeparted = $request->dateDeparted;

    $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first()->destination_id;
    //$destination = $terminals->destination_id == $mainTerminal ? $request->origin : $mainTerminal;
    //$destinationname = Destination::find($destination);

    if($terminals->destination_id == $mainTerminal){
      if($totalPassengers >=  10){
        $trip = Trip::create([
           'driver_id' => $driver_id,
           'van_id' => $vanid,
           'destination' => $destination->destination_name,
           'origin' => $terminals->destination_name,
           'total_passengers' => $totalPassengers,
           'total_booking_fee' => $totalBookingFee,
           'community_fund' => $cf*$totalPassengers,
           'SOP' => $sop,
           'date_departed' => $request->dateDeparted,
           'time_departed' => $timeDepartedFormat,
           'report_status' => 'Accepted',
        ]);

       $insertLegderQuery = array(
          array('description' => 'SOP', 'amount' => $trip->SOP, 'type' => 'Revenue'),
          array('description' => 'Booking Fee', 'amount' => $trip->total_booking_fee, 'type' => 'Revenue'),
        );

        Ledger::insert($insertLegderQuery);

     }else if($totalPassengers <  10){
        $trip = Trip::create([
           'driver_id' => $driver_id,
           'van_id' => $vanid,
           'destination' => $destination->destination_name,
           'origin' => $terminals->destination_name,
           'total_passengers' => $totalPassengers,
           'total_booking_fee' => $totalBookingFee,
           'community_fund' => $cf*$totalPassengers,
           'SOP' => $sop,
           'date_departed' => $request->dateDeparted,
           'time_departed' => $timeDepartedFormat,
           'report_status' => 'Accepted',
         ]);

        Ledger::create([
            'description' => 'Booking Fee',
            'amount' => $trip->total_booking_fee,
            'type' => 'Revenue',
          ]);

     }
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

           if($numofpassenger_discount !== null){
             for($i = 0; $i < $numofpassenger; $i++){
               if($numofpassenger_discount > 0){
                 $amountpaid = Ticket::where('destination_id', $destinationid)->where('type','Discount')->first()->fare;
               }else{
                 $amountpaid = Ticket::where('destination_id', $destinationid)->where('type','Regular')->first()->fare;
               }
               //echo $destination_name->destination_name . ' ' . $amountpaid . '<br/>' ;
               Transaction::create([
                 "trip_id" => $trip->trip_id,
                 "destination" => $destination_name->destination_name,
                 "origin" => $terminals->destination_name,
                 "amount_paid" => $amountpaid,
                 "status" => "Departed",
               ]);

               //echo $destination_name->destination_name . ' ' . $numofpassenger . ' ' . $amountpaid . ' ' . $numofpassenger_discount . '<br/>' ;
               $numofpassenger_discount--;
             }
           }else{
             for($i = 0; $i < $numofpassenger; $i++){
               $amountpaid = Ticket::where('destination_id', $destinationid)->where('type','Regular')->first()->fare;
               echo $destination_name->destination_name . ' ' . $amountpaid . '<br/>' ;
               Transaction::create([
                 "trip_id" => $trip->trip_id,
                 "destination" => $destination_name->destination_name,
                 "origin" => $terminals->destination_name,
                 "amount_paid" => $amountpaid,
                 "status" => "Departed",
               ]);
               //echo $destination_name->destination_name . ' ' . $numofpassenger . ' ' . $amountpaid . ' ' . $numofpassenger_discount . '<br/>' ;
             }
           }
         }
       }
     }

    }else{
      if($totalPassengers >=  10){
         $trip =Trip::create([
          'driver_id' => $driver_id,
          'van_id' => $vanid,
          'destination' => $destination->destination_name,
          'origin' => $terminals->destination_name,
          'total_passengers' => $totalPassengers,
          'total_booking_fee' => $totalBookingFee,
          'community_fund' => $cf*$totalPassengers,
          'report_status' => 'Accepted',
          'date_departed' => $request->dateDeparted,
          'time_departed' => $timeDepartedFormat,
        ]);
      }else if($totalPassengers <  10){
         $trip = Trip::create([
           'driver_id' => $driver_id,
           'van_id' => $vanid,
           'destination' => $destination->destination_name,
           'origin' => $terminals->destination_name,
           'total_passengers' => $totalPassengers,
           'total_booking_fee' => $totalBookingFee,
           'community_fund' => $cf*$totalPassengers,
           'report_status' => 'Accepted',
           'date_departed' => $request->dateDeparted,
           'time_departed' => $timeDepartedFormat,
         ]);
      }

      $numberofmainpassengers = $request->numPassMain;
      $numberofmaindiscount = $request->numDisMain;
      $numberofstpassengers = $request->numPassST;
      $numberofstdiscount = $request->numDisST;

      $terminal = Destination::find($request->orgId);
      $shortTripFare = $terminal->short_trip_fare;
      $shortTripDiscountFare = $terminal->short_trip_fare_discount;

      $mainterm = Destination::where('is_main_terminal', true)->first()->destination_name;
      if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers !== null && $numberofstdiscount !== null)){

            for($i = 0; $i < $numberofmainpassengers; $i++){
               if($numberofmaindiscount > 0){
                 $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
                 $amountpaid = $terminalfare;
               }else{
                 $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
                 $amountpaid = $terminalfare;
               }

               Transaction::create([
                 "trip_id" => $trip->trip_id,
                 "destination" => $mainterm,
                 "origin" => $terminal->destination_name,
                 "amount_paid" => $amountpaid,
                 "status" => "Departed",
               ]);

               $numberofmaindiscount--;
            }

            for($i = 0; $i < $numberofstpassengers; $i++){
               if($numberofstdiscount > 0){
                 $amountpaid = $shortTripDiscountFare;
               }else{
                 $amountpaid = $shortTripFare;
               }

               Transaction::create([
                 "trip_id" => $trip->trip_id,
                 "destination" => $mainterm,
                 "origin" => $terminal->destination_name,
                 "amount_paid" => $amountpaid,
                 "status" => "Departed",
               ]);

               $numberofstdiscount--;
            }

      }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
         ($numberofstpassengers !== null && $numberofstdiscount == null)){

         $amountpaid = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;;

         for($i = 0; $i < $numberofmainpassengers; $i++){
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
           ]);
         }

         for($i = 0; $i < $numberofstpassengers; $i++){
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $shortTripFare,
             "status" => "Departed",
           ]);
         }

      }else if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers == null && $numberofstdiscount == null)){

         for($i = 0; $i < $numberofmainpassengers; $i++){
           if($numberofmaindiscount > 0){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
           }else{
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
             $amountpaid = $terminalfare;
           }

           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
           ]);

           $numberofmaindiscount--;
         }

      }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
         ($numberofstpassengers == null && $numberofstdiscount == null)){
         $amountpaid = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;;

         for($i = 0; $i < $numberofmainpassengers; $i++){
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
           ]);
         }

      }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
         ($numberofstpassengers !== null && $numberofstdiscount !== null)){

         for($i = 0; $i < $numberofstpassengers; $i++){
               if($numberofstdiscount > 0){
                 $amountpaid = $shortTripDiscountFare;
               }else{
                 $amountpaid = $shortTripFare;
               }

               Transaction::create([
                 "trip_id" => $trip->trip_id,
                 "destination" => $mainterm,
                 "origin" => $terminal->destination_name,
                 "amount_paid" => $amountpaid,
                 "status" => "Departed",
               ]);

               $numberofstdiscount--;
            }

      }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
         ($numberofstpassengers !== null && $numberofstdiscount == null)){

         for($i = 0; $i < $numberofstpassengers; $i++){
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $shortTripFare,
             "status" => "Departed",
           ]);
         }
      }
    }
  return redirect('home/terminal')->with('success', 'Successfully created a report!');
  }
}
