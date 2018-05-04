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
    $member = Member::where('user_id', Auth::id())->first();
    return view('drivermodule.report.driverCreateReport', compact('terminals', 'destinations', 'fad', 'member'));
  }
  public function storeReport(Destination $terminal, CreateReportRequest $request)
  {
    //dd(request('destination'));
    $totalPassengers = $request->totalPassengers;
    $totalBookingFee = $request->totalBookingFee;
    $totalPassenger = (float)$request->totalPassengers;
    $cf = Fee::where('description', 'Community Fee')->first();
    $communityFund = number_format($cf->amount * $totalPassenger, 2, '.', '');
    $sop = Fee::where('description', 'SOP')->first();
    $driver_user = User::find(Auth::id());
    $van_id = $driver_user->member->van->first()->van_id;
    $driver_id = Member::where('user_id', Auth::id())->select('member_id')->first();
    $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
    $timeDepartedFormat = $timeDeparted->format('H:i:s');
    $dateDeparted = $request->dateDeparted;
     if($totalPassengers >=  10){
        Trip::create([
         'driver_id' => $driver_id->member_id,
         'van_id' => $van_id,
         'destination' => $request->destinationName,
         'origin' => $terminal->destination_name,
         'total_passengers' => $totalPassengers,
         'total_booking_fee' => $totalBookingFee,
         'community_fund' => $communityFund,
         'SOP' => $sop,
         'report_status' => 'Pending',
         'date_departed' => $request->dateDeparted,
         'time_departed' => $timeDepartedFormat,
       ]);
     }else if($totalPassengers <  10){
          Trip::create([
            'driver_id' => $driver_id->member_id,
            'van_id' => $van_id,
            'destination' => $request->destinationName,
            'origin' => $terminal->destination_name,
            'total_passengers' => $totalPassengers,
            'total_booking_fee' => $totalBookingFee,
            'community_fund' => $communityFund,
            'report_status' => 'Pending',
            'date_departed' => $request->dateDeparted,
            'time_departed' => $timeDepartedFormat,
         ]);
     }

    $destinationIdArr = request('destination');
    $destinationNameArr = null;
    foreach($destinationIdArr  as $key => $value){
      $d = Destination::find($value);
      $destinationNameArr[$key] = $d->destination_name;
    }

    $numOfPassengers = request('qty');
    $numOfDiscount = request('dis');
    $ticketArr = null;
    $discountTransactionArr = null;
    dd($numOfDiscount);
    for($i = 0; $i < count($numOfPassengers); $i++){
      if(!($numOfPassengers[$i] == null)){
        $ticketArr[$i] = array($destinationNameArr[$i] => $numOfPassengers[$i]);
      }else{
        continue;
      }
    }

    $tripId = Trip::latest()->select('trip_id')->first();
    $insertTicketArr = array_values($ticketArr);
    foreach($insertTicketArr as $ticketKey => $innerTicketArrays){
      foreach($innerTicketArrays as $innerTicketKeys => $innerTicketValues){

        for($i = 1; $i <= $innerTicketValues; $i++){
          Transaction::create([
            "trip_id" => $tripId->trip_id,
            "destination" => $innerTicketKeys,
            "origin" => $terminal->destination_name,
            "status" => 'Departed',
          ]);
        }
      }
    }

    if($numOfDiscount != null){
      $discountTransactionArr = array_combine($discountArr, $numOfDiscount);
      $latestTrip = Trip::latest()->first();
      $transaction = Transaction::orderBy('created_at', 'desc')->get();
      $updateQueryCount = $totalPassengers;

     $counter = 0;
     foreach($discountTransactionArr as $key => $value){
         $numOfDiscount = $value;
         if($numOfDiscount == null){
           //echo $numOfDiscount . "hi <br/>";
           continue;
         }else{

           while($numOfDiscount != 0){
             $check = $transaction[$counter]->update([
               "fad_id" => $key,
             ]);
             //echo $counter . " " . $key . " " . $numOfDiscount . " " . $check . "<br/>";
             $counter++;
             $numOfDiscount--;
           }
         }
     }
    }



  return redirect('home/choose-terminal')->with('success', 'Report created successfully!');


  }
}
