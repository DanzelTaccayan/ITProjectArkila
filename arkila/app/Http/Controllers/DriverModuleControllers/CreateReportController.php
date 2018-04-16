<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateReportRequest;
use App\Http\Controllers\Controller;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use Carbon\Carbon;
use App\FeesAndDeduction;
use App\Destination;
use App\Transaction;
use App\Terminal;
use App\Member;
use App\Ticket;
use App\Trip;
use App\User;

class CreateReportController extends Controller
{
  public function chooseTerminal()
  {
    $terminals = Terminal::orderBy('terminal_id')->get();
    $superAdmin = User::where('user_type', 'Super-Admin')->first();
    $superAdminTerminal = $superAdmin->terminal->description;
    return view('drivermodule.report.driverChooseDestination',compact('terminals', 'superAdminTerminal'));

  }

  public function createReport(Terminal $terminals)
  {
    $destinations = Destination::join('terminal', 'destination.terminal_id', '=', 'terminal.terminal_id')
                    ->where('terminal.terminal_id', '=', $terminals->terminal_id)
                    ->select('terminal.terminal_id as term_id','terminal.description as termdesc', 'destination.destination_id as destid', 'destination.description')->get();
    $fad = FeesAndDeduction::where('type','=','Discount')->first();
    $member = Member::where('user_id', Auth::id())->first();
    return view('drivermodule.report.driverCreateReport', compact('terminals', 'destinations', 'fad', 'member'));
  }
  public function storeReport(Terminal $terminal, CreateReportRequest $request)
  {
    $totalPassengers = $request->totalPassengers;
    $totalBookingFee = $request->totalBookingFee;
    $totalPassenger = (float)$request->totalPassengers;
    $communityFund = number_format(5 * $totalPassenger, 2, '.', '');
    $user = new User;
    $plateNumber = $user->join('member', 'users.id', '=', 'member.user_id')
          ->join('member_van', 'member.member_id', '=', 'member_van.member_id')
          ->join('van', 'member_van.plate_number', '=', 'van.plate_number')
          ->where('users.id', Auth::id())->select('van.plate_number as plate_number')->first();
     $driver_id = Member::where('user_id', Auth::id())->select('member_id')->first();

     $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
     $timeDepartedFormat = $timeDeparted->format('H:i:s');
     $dateDeparted = $request->dateDeparted;
     if($totalPassengers >=  10){
        Trip::create([
         'driver_id' => $driver_id->member_id,
         'origin' => $terminal->terminal_id,
         'terminal_id' => $terminal->terminal_id,
         'plate_number' => $plateNumber->plate_number,
         'status' => 'Departed',
         'total_passengers' => $totalPassengers,
         'total_booking_fee' => $request->totalBookingFee,
         'community_fund' => $communityFund,
         'date_departed' => $request->dateDeparted,
         'time_departed' => $timeDepartedFormat,
         'report_status' => 'Pending',
         'SOP' => 100.00,
       ]);
     }else if($totalPassengers <  10){
          Trip::create([
           'driver_id' => $driver_id->member_id,
           'origin' => $terminal->terminal_id,
           'terminal_id' => $terminal->terminal_id,
           'plate_number' => $plateNumber->plate_number,
           'status' => 'Departed',
           'total_passengers' => $totalPassengers,
           'total_booking_fee' => $request->totalBookingFee,
           'community_fund' => $communityFund,
           'date_departed' => $request->dateDeparted,
           'time_departed' => $timeDepartedFormat,
           'report_status' => 'Pending',
         ]);
     }

    $destinationArr = request('destination');
    $numOfPassengers = request('qty');
    $discountArr = request('discountId');
    $numOfDiscount = request('numberOfDiscount');
    $ticketArr = null;
    $discountTransactionArr = null;

    for($i = 0; $i < count($numOfPassengers); $i++){
      if(!($numOfPassengers[$i] == null)){
        $ticketArr[$i] = array($destinationArr[$i] => $numOfPassengers[$i]);
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
            "destination_id" => $innerTicketKeys,
            'terminal_id' => $terminal->terminal_id,
            "trip_id" => $tripId->trip_id,
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
