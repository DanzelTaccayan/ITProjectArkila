<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
  // public function chooseTerminal()
  // {
  //   $origins = Destination::where('is_terminal', true)->where('is_main_terminal', false)->get();
  //   $mainTerminal =  Destination::where('is_terminal', true)->where('is_main_terminal', true)->first();
  //   return view('drivermodule.report.driverChooseDestination',compact('origins','mainTerminal'));

  // }

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
    //dd(request('destinationName'));
    $terminal = Destination::find($request->origin);
    $totalPassengers = $request->totalPassengers;

    $totalPassenger = (float)$request->totalPassengers;
    $cf = Fee::where('description', 'Community Fund')->first();
    $totalbookingfee = number_format($terminal->booking_fee * $totalPassenger, 2, '.', '');

    $sop = Fee::where('description', 'SOP')->first();

    $driver_user = User::find(Auth::id());
    $van_id = $driver_user->member->van->first()->van_id;
    $driver_id = Member::where('user_id', Auth::id())->select('member_id')->first();

    $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
    $timeDepartedFormat = $timeDeparted->format('H:i:s');
    $dateDeparted = $request->dateDeparted;

    $mainterminal = Destination::where('is_main_terminal', true)->first();

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
     'time_departed' => $timeDepartedFormat,
     'reportedBy' => 'Driver',
   ]);

     $numberofmainpassengers = $request->numPassMain;
     $numberofmaindiscount = $request->numDisMain;
     $numberofstpassengers = $request->numPassST;
     $numberofstdiscount = $request->numDisST;
     $shortTripFare = $terminal->short_trip_fare;
     $shortTripDiscountFare = $terminal->short_trip_fare_discount;

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
                "destination" => $mainterminal->destination_name,
                "origin" => $terminal->destination_name,
                "amount_paid" => $amountpaid,
                "status" => "Pending",
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
                "destination" => $mainterminal->destination_name,
                "origin" => $terminal->destination_name,
                "amount_paid" => $amountpaid,
                "status" => "Pending",
              ]);

              $numberofstdiscount--;
           }

     }else if(($numberofmainpassengers !== null && $numberofmaindiscount == null) &&
        ($numberofstpassengers !== null && $numberofstdiscount == null)){

        $amountpaid = Ticket::where('destination_id', $terminal->destination_id)->where('type','Regular')->first()->fare;;

        for($i = 0; $i < $numberofmainpassengers; $i++){
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
          ]);
        }

        for($i = 0; $i < $numberofstpassengers; $i++){
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $shortTripFare,
            "status" => "Pending",
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
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $amountpaid,
            "status" => "Pending",
          ]);

          $numberofmaindiscount--;
        }

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
                "destination" => $mainterminal->destination_name,
                "origin" => $terminal->destination_name,
                "amount_paid" => $amountpaid,
                "status" => "Pending",
              ]);

              $numberofstdiscount--;
           }

     }else if(($numberofmainpassengers == null && $numberofmaindiscount == null) &&
        ($numberofstpassengers !== null && $numberofstdiscount == null)){

        for($i = 0; $i < $numberofstpassengers; $i++){
          Transaction::create([
            "trip_id" => $trip->trip_id,
            "destination" => $mainterminal->destination_name,
            "origin" => $terminal->destination_name,
            "amount_paid" => $shortTripFare,
            "status" => "Pending",
          ]);
        }
     }
    // $destinationIdArr = request('destination');
    // $destinationNameArr = null;
    // foreach($destinationIdArr  as $key => $value){
    //   $d = Destination::find($value);
    //   $destinationNameArr[$key] = $d->destination_name;
    // }

    // $numOfPassengers = request('qty');
    // $numOfDiscount = request('dis');
    // $ticketArr = null;
    // $discountTransactionArr = null;
    // dd($numOfDiscount);
    // for($i = 0; $i < count($numOfPassengers); $i++){
    //   if(!($numOfPassengers[$i] == null)){
    //     $ticketArr[$i] = array($destinationNameArr[$i] => $numOfPassengers[$i]);
    //   }else{
    //     continue;
    //   }
    // }

    // $tripId = Trip::latest()->select('trip_id')->first();
    // $insertTicketArr = array_values($ticketArr);
    // foreach($insertTicketArr as $ticketKey => $innerTicketArrays){
    //   foreach($innerTicketArrays as $innerTicketKeys => $innerTicketValues){

    //     for($i = 1; $i <= $innerTicketValues; $i++){
    //       Transaction::create([
    //         "trip_id" => $tripId->trip_id,
    //         "destination" => $innerTicketKeys,
    //         "origin" => $terminal->destination_name,
    //         "status" => 'Departed',
    //       ]);
    //     }
    //   }
    // }

    // if($numOfDiscount != null){
    //   $discountTransactionArr = array_combine($discountArr, $numOfDiscount);
    //   $latestTrip = Trip::latest()->first();
    //   $transaction = Transaction::orderBy('created_at', 'desc')->get();
    //   $updateQueryCount = $totalPassengers;

    //  $counter = 0;
    //  foreach($discountTransactionArr as $key => $value){
    //      $numOfDiscount = $value;
    //      if($numOfDiscount == null){
    //        //echo $numOfDiscount . "hi <br/>";
    //        continue;
    //      }else{

    //        while($numOfDiscount != 0){
    //          $check = $transaction[$counter]->update([
    //            "fad_id" => $key,
    //          ]);
    //          //echo $counter . " " . $key . " " . $numOfDiscount . " " . $check . "<br/>";
    //          $counter++;
    //          $numOfDiscount--;
    //        }
    //      }
    //  }
    // }



  return redirect('/home/create-report')->with('success', 'Report created successfully!');


  }
}
