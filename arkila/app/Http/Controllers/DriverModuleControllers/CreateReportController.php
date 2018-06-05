<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TripReportsAdminNotification;
use App\Http\Requests\CreateReportRequest;
use App\Http\Controllers\Controller;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use Carbon\Carbon;
use App\Destination;
use App\Transaction;
use App\Terminal;
use App\Member;
use App\Ticket;
use App\Trip;
use App\User;
use App\Fee;
class CreateReportController extends Controller
{

  public function createReport()
  {
    $origins = Destination::where('is_terminal', true)->where('is_main_terminal', false)->get();
    $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first();
    //$destinations = $terminals->routeFromDestination;
    $fees = Fee::all();
    $dateNow = Carbon::now()->format('m/d/Y');
    $timeNow = Carbon::now()->format('g:i A');

    $member = Member::where('user_id', Auth::id())->first();
    return view('drivermodule.report.driverCreateReport', compact('dateNow', 'timeNow','terminals', 'destinations', 'fad', 'member', 'origins'));
  }
  public function storeReport(CreateReportRequest $request)
  {
    $terminal = Destination::find($request->origin);
    $totalPassengers = $request->totalPassengers;

    $totalPassenger = (float)$request->totalPassengers;
    $cf = Fee::where('description', 'Community Fund')->first();
    $totalbookingfee = number_format($terminal->booking_fee * $totalPassenger, 2, '.', '');

    $sop = Fee::where('description', 'SOP')->first();

    $driver_user = User::find(Auth::id());
    $van_id = $driver_user->member->van->first()->van_id;
    $driver_id = Member::where('user_id', Auth::id())->select('member_id')->first();

    $dateDeparted = $request->dateDeparted;

    $mainterminal = Destination::where('is_main_terminal', true)->first();

    $dateTimeToday = Carbon::now();
    $timeRequest = explode(':', $request->timeDeparted);
    $dateRequest = Carbon::parse($request->dateDeparted)->setTime($timeRequest[0], $timeRequest[1], 00);


    if($dateTimeToday->lte($dateRequest)) {
      return back()->withErrors('The time deprated cannot be after ' . $dateTimeToday->format('g:i A'));
    }else{

    $trip =Trip::create([
     'driver_id' => $driver_id->member_id,
     'van_id' => $van_id,
     'destination' => $mainterminal->destination_name,
     'origin' => $terminal->destination_name,
     'total_passengers' => $totalPassengers,
     'total_booking_fee' => $totalbookingfee,
     'community_fund' => $cf->amount*$totalPassengers,
     'report_status' => 'Pending',
     'date_departed' => $request->dateDeparted,
     'time_departed' => $request->timeDeparted,
     'reported_by' => 'Driver',
   ]);

     $numberofmainpassengers = $request->numPassMain;
     $numberofmaindiscount = $request->numDisMain;
     $numberofstpassengers = $request->numPassST;
     $numberofstdiscount = $request->numDisST;
     $shortTripFare = $terminal->short_trip_fare;
     $shortTripDiscountFare = $terminal->short_trip_fare_discount;

     //1. If all are true
     if(($numberofmainpassengers !== null && $numberofmaindiscount !== null) &&
        ($numberofstpassengers !== null && $numberofstdiscount !== null)){
          for($i = 0; $i < $numberofmainpassengers; $i++){
            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;
            $amountpaid = $terminalfare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Regular",
              "is_short_trip" => false,
            ]);
          }

          for($i = 0; $i < $numberofmaindiscount; $i++){
            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
            $amountpaid = $terminalfare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Discount",
              "is_short_trip" => false,
            ]);
          }

          for($i = 0; $i < $numberofstpassengers; $i++){
            $amountpaid = $shortTripFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Regular",
              "is_short_trip" => true,
            ]);
          }

          for($i = 0; $i < $numberofstdiscount; $i++){
            $amountpaid = $shortTripDiscountFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => false,
          ]);
        }

        for($i = 0; $i < $numberofstpassengers; $i++){
          $amountpaid = $shortTripFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => true,
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => false,
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Discount",
            "is_short_trip" => false,
          ]);
        }

        for($i = 0; $i < $numberofstpassengers; $i++){
          $amountpaid = $shortTripFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => true,
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => true,
          ]);
        }

        for($i = 0; $i < $numberofstdiscount; $i++){
          $amountpaid = $shortTripDiscountFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => false,
          ]);
        }
        for($i = 0; $i < $numberofstpassengers; $i++){
          $amountpaid = $shortTripFare;
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
            "transaction_ticket_type" => "Regular",
            "is_short_trip" => true,
          ]);
        }

      }else if(($numberofmainpassengers == null && $numberofmaindiscount !== null) &&
        ($numberofstpassengers !== null && $numberofstdiscount !== null)){
          for($i = 0; $i < $numberofmaindiscount; $i++){
            $terminalfare = Ticket::where('destination_id', $terminal->destination_id)->where('type','Discount')->first()->fare;
            $amountpaid = $terminalfare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Discount",
              "is_short_trip" => false,
            ]);
          }

          for($i = 0; $i < $numberofstpassengers; $i++){
            $amountpaid = $shortTripFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Regular",
              "is_short_trip" => true,
            ]);
          }

          for($i = 0; $i < $numberofstdiscount; $i++){
            $amountpaid = $shortTripDiscountFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Discount",
              "is_short_trip" => true,
            ]);
          }
      }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
        ($numberofstpassengers !== null && $numberofstdiscount == null)){
          for($i = 0; $i < $numberofstpassengers; $i++){
            $amountpaid = $shortTripFare;
            Transaction::create([
              "trip_id" => $trip->trip_id,
              "destination" => $mainterminal->destination_name,
              "origin" => $terminal->destination_name,
              "amount_paid" => $amountpaid,
              "status" => "Pending",
              "transaction_ticket_type" => "Regular",
              "is_short_trip" => true,
            ]);
          }
      }
    }

    return redirect('/home/view-trips/'.$trip->trip_id)->with('success', 'Report created successfully!');

  }
}
