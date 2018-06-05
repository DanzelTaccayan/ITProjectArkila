<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TripReportsDriverNotification;
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
    //     echo $fs . '<br/>';
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
    $driverAndOperators = Member::where('license_number', '!=', null)->get();
    $plate_numbers = Van::all();
    $member = Member::where('user_id', Auth::id())->first();


    return view('trips.createReport', compact('origins','terminals', 'destinations', 'destination', 'member', 'driverAndOperators', 'plate_numbers'));
  }

  public function storeReport(Destination $terminals, Destination $destination, AdminCreateDriverReportRequest $request)
  {

   	$totalPassengers = $request->totalPassengers;
    $totalBookingFee = $terminals->booking_fee * $totalPassengers;
    $totalPassenger = (float)$request->totalPassengers;

    $cf = Fee::where('description', 'Community Fund')->first()->amount;
    $sop = Fee::where('description', 'SOP')->first()->amount;

    $user = new User;

    $driver_id = $request->driverAndOperator;


    $mainterminal = Destination::where('is_main_terminal', true)->first()->destination_name;
    $vanid = $request->van_platenumber;
    $dateDeparted = $request->dateDeparted;

    $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first()->destination_id;

    $dateTimeToday = Carbon::now();
    $timeRequest = explode(':', $request->timeDeparted);
    $dateRequest = Carbon::parse($request->dateDeparted)->setTime($timeRequest[0], $timeRequest[1], 00);

    if($dateTimeToday->lte($dateRequest)) {
      return back()->withErrors('The time deprated cannot be after ' . $dateTimeToday->format('g:i A'));
    } else {

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
           'time_departed' => $request->timeDeparted,
           'report_status' => 'Accepted',
           'reported_by' => 'Admin',
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
           'date_departed' => $request->dateDeparted,
           'time_departed' => $request->timeDeparted,
           'report_status' => 'Accepted',
           'reported_by' => 'Admin',
         ]);

        Ledger::create([
            'description' => 'Booking Fee',
            'amount' => $trip->total_booking_fee,
            'type' => 'Revenue',
          ]);

     }
     $destinationArr = request('destination');
     $numOfPassengers = request('qty');
     $numOfDiscountPassengers = request('disqty');

     $ticketArr = null;

     $transanctionArr = null;

     for($i = 0; $i < count($destinationArr); $i++){
        if(($numOfPassengers[$i] !== null || $numOfPassengers[$i] != 0)
        && ($numOfDiscountPassengers[$i] !== null || $numOfDiscountPassengers[$i] != 0)){
          $ticketArr[$i] = array($destinationArr[$i] => array(
            'numOfRegPass' => $numOfPassengers[$i] == 0 ? 0 : $numOfPassengers[$i],
            'numOfDisPass' => $numOfDiscountPassengers[$i] == 0 ? 0 : $numOfDiscountPassengers[$i],
          ));
        }else{
          continue;
        }
      }

      foreach($ticketArr as $key => $innerArray){
        foreach($innerArray as $innerArrayKeys => $innerArrayValues){
          foreach($innerArrayValues as $numPassKey => $numPassValue){
            if($numPassValue != 0){
              $ticketType = $numPassKey == 'numOfRegPass' ? 'Regular' : 'Discount';
              for($i = 0; $i < $numPassValue; $i++){
                $amountpaid = Ticket::where('destination_id', $innerArrayKeys)->where('type', $ticketType)->first()->fare;
                //echo $key . ' ' . $amountpaid . ' ' . $innerArrayKeys . ' ' . $i . ' ' . $numPassValue . '<br/>';
                $destination_name = Destination::find($innerArrayKeys);
                Transaction::create([
                  "trip_id" => $trip->trip_id,
                  "destination" => $destination_name->destination_name,
                  "origin" => $terminals->destination_name,
                  "amount_paid" => $amountpaid,
                  "status" => "Departed",
                  "transaction_ticket_type" => $ticketType,
                  "is_short_trip" => false,
                ]);
              }
            }
          }
        }
      }
      //dd($ticketArr);
    }else{
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
        'time_departed' => $request->timeDeparted,
        'reported_by' => 'Admin'
      ]);

      $numberofmainpassengers = $request->numPassMain;
      $numberofmaindiscount = $request->numDisMain;
      $numberofstpassengers = $request->numPassST;
      $numberofstdiscount = $request->numDisST;

      $terminal = Destination::find($request->orgId);
      $shortTripFare = $terminal->short_trip_fare;
      $shortTripDiscountFare = $terminal->short_trip_fare_discount;

      $mainterm = Destination::where('is_main_terminal', true)->first()->destination_name;
      //1. If all are true
      if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers !== null && $numberofstdiscount !== null)){
           for($i = 0; $i < $numberofmainpassengers; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofstpassengers; $i++){
             $amountpaid = $shortTripFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => true,
             ]);
           }

           for($i = 0; $i < $numberofstdiscount; $i++){
             $amountpaid = $shortTripDiscountFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => true,
             ]);
           }
       //2. If num of dis main pass is false
      }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
      ($numberofstpassengers !== null && $numberofstdiscount !== null)){
         for($i = 0; $i < $numberofmainpassengers; $i++){
           $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
           $amountpaid = $terminalfare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => false,
           ]);
         }

         for($i = 0; $i < $numberofstpassengers; $i++){
           $amountpaid = $shortTripFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => true,
           ]);
         }

         for($i = 0; $i < $numberofstdiscount; $i++){
           $amountpaid = $shortTripDiscountFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Discount",
             "is_short_trip" => true,
           ]);
         }
       //3. If num of dis main pass and num st pass is false
      }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
      ($numberofstpassengers == null && $numberofstdiscount !== null)){
         for($i = 0; $i < $numberofmainpassengers; $i++){
           $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
           $amountpaid = $terminalfare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => false,
           ]);
         }

         for($i = 0; $i < $numberofstdiscount; $i++){
           $amountpaid = $shortTripDiscountFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Discount",
             "is_short_trip" => true,
           ]);
         }
      //4. If num of dis main pass, num st pass, and num st pass are false
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
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => false,
           ]);
         }
       //5. If num main pass is false
       }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
       ($numberofstpassengers !== null && $numberofstdiscount !== null)){
         for($i = 0; $i < $numberofmaindiscount; $i++){
           $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
           $amountpaid = $terminalfare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Discount",
             "is_short_trip" => false,
           ]);
         }

         for($i = 0; $i < $numberofstpassengers; $i++){
           $amountpaid = $shortTripFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => true,
           ]);
         }

         for($i = 0; $i < $numberofstdiscount; $i++){
           $amountpaid = $shortTripDiscountFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Discount",
             "is_short_trip" => true,
           ]);
         }
       //6. if num main pass and num main dis pass are false
       }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
       ($numberofstpassengers !== null && $numberofstdiscount !== null)){
         for($i = 0; $i < $numberofstpassengers; $i++){
           $amountpaid = $shortTripFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => true,
           ]);
         }

         for($i = 0; $i < $numberofstdiscount; $i++){
           $amountpaid = $shortTripDiscountFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Discount",
             "is_short_trip" => true,
           ]);
         }
       //7. if num main pass, num main dis pass, and  are false
       }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
       ($numberofstpassengers == null && $numberofstdiscount !== null)){
         for($i = 0; $i < $numberofstdiscount; $i++){
           $amountpaid = $shortTripDiscountFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Discount",
             "is_short_trip" => true,
           ]);
         }
       //8. if numdis main and num dis st are null
     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
       ($numberofstpassengers !== null && $numberofstdiscount == null)){
         for($i = 0; $i < $numberofmainpassengers; $i++){
           $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
           $amountpaid = $terminalfare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => false,
           ]);
         }
         for($i = 0; $i < $numberofstpassengers; $i++){
           $amountpaid = $shortTripFare;
           Transaction::create([
             "trip_id" => $trip->trip_id,
             "destination" => $mainterm,
             "origin" => $terminal->destination_name,
             "amount_paid" => $amountpaid,
             "status" => "Departed",
             "transaction_ticket_type" => "Regular",
             "is_short_trip" => true,
           ]);
         }
       //9.
       }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers !== null && $numberofstdiscount !== null)){
           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofstpassengers; $i++){
             $amountpaid = $shortTripFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => true,
             ]);
           }

           for($i = 0; $i < $numberofstdiscount; $i++){
             $amountpaid = $shortTripDiscountFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => true,
             ]);
           }
       //10.
       }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
         ($numberofstpassengers !== null && $numberofstdiscount == null)){
           for($i = 0; $i < $numberofstpassengers; $i++){
             $amountpaid = $shortTripFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => true,
             ]);
           }
       //11.
       }else if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers !== null && $numberofstdiscount == null)){
           for($i = 0; $i < $numberofmainpassengers; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofstpassengers; $i++){
             $amountpaid = $shortTripFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => true,
             ]);
           }
       //12.
       }else if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers == null && $numberofstdiscount == null)){
           for($i = 0; $i < $numberofmainpassengers; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }
       //13.
       }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers == null && $numberofstdiscount == null)){
           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
           ]);
         }
       //14.
       }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers == null && $numberofstdiscount !== null)){
           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofstdiscount; $i++){
             $amountpaid = $shortTripDiscountFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => true,
             ]);
           }
       //15.
       }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers == null && $numberofstdiscount == null)){
           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }
       //16.
       }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
         ($numberofstpassengers !== null && $numberofstdiscount == null)){
           for($i = 0; $i < $numberofmaindiscount; $i++){
             $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
             $amountpaid = $terminalfare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Discount",
               "is_short_trip" => false,
             ]);
           }

           for($i = 0; $i < $numberofstpassengers; $i++){
             $amountpaid = $shortTripFare;
             Transaction::create([
               "trip_id" => $trip->trip_id,
               "destination" => $mainterm,
               "origin" => $terminal->destination_name,
               "amount_paid" => $amountpaid,
               "status" => "Departed",
               "transaction_ticket_type" => "Regular",
               "is_short_trip" => true,
             ]);
           }
       }
      }
    }
  return redirect('home/trip-log/'.$trip->trip_id)->with('success', 'Successfully created a report!');
  }
}
