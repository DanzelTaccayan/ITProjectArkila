<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminCreateDriverReportRequest;
use App\Http\Controllers\Controller;
use App\Rules\checkCurrency;
use App\Rules\checkTime;
use Carbon\Carbon;
use App\FeesAndDeduction;
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
    $terminals = Terminal::orderBy('terminal_id')->get();
    $superAdmin = User::where('user_type', 'Super-Admin')->first();
    $superAdminTerminal = Terminal::where('terminal_id', Auth::user()->terminal_id)->first() ?? null;
    
    return view('trips.chooseDestination',compact('terminals', 'superAdminTerminal'));
  }

  public function createReport(Terminal $terminals)
  {
  	if($terminals->terminal_id == Auth::user()->terminal_id){
  		$destinations = Destination::join('terminal', 'destination.terminal_id', '=', 'terminal.terminal_id')
            ->select('terminal.terminal_id as term_id','terminal.description as termdesc', 'destination.destination_id as destid', 'destination.description')->get();	
  	}else{
  		$destinations = Destination::join('terminal', 'destination.terminal_id', '=', 'terminal.terminal_id')
        	->where('terminal.terminal_id', '=', $terminals->terminal_id)
            ->select('terminal.terminal_id as term_id','terminal.description as termdesc', 'destination.destination_id as destid', 'destination.description')->get();
  	}
    
    $driverAndOperators = Member::where('role', 'Operator')->orWhere('role', 'Driver')->get();
    $plate_numbers = Van::all();                
    $fads = FeesAndDeduction::where('type','=','Discount')->get();
    $member = Member::where('user_id', Auth::id())->first();
    return view('trips.createReport', compact('terminals', 'destinations', 'fads', 'member', 'driverAndOperators', 'plate_numbers'));
  }

  public function storeReport(Terminal $terminals, AdminCreateDriverReportRequest $request)
  {
  	
   	$totalPassengers = $request->totalPassengers;
    $totalBookingFee = $request->totalBookingFee;
    $totalPassenger = (float)$request->totalPassengers;
    $communityFund = number_format(5 * $totalPassenger, 2, '.', '');
    $user = new User;
    $plateNumber = $request->plateNumber;
     $driver_id = $request->driverAndOperator;

     $timeDeparted = Carbon::createFromFormat('h:i A', $request->timeDeparted);
     $timeDepartedFormat = $timeDeparted->format('H:i:s');
     $dateDeparted = $request->dateDeparted;
     if($totalPassengers >=  10){
        $trip = Trip::create([
         'driver_id' => $driver_id,
         'origin' => $terminals->terminal_id,
         'terminal_id' => $terminals->terminal_id,
         'plate_number' => $plateNumber,
         'status' => 'Departed',
         'total_passengers' => $totalPassengers,
         'total_booking_fee' => $request->totalBookingFee,
         'community_fund' => $communityFund,
         'date_departed' => $request->dateDeparted,
         'time_departed' => $timeDepartedFormat,
         'report_status' => 'Accepted',
         'SOP' => 100.00,
       ]);
       
       if($terminals->terminal_id == Auth::user()->terminal_id){
       	$insertLegderQuery = array(
       		array('description' => 'SOP', 'amount' => $trip->SOP, 'type' => 'Revenue'),
       		array('description' => 'Booking Fee', 'amount' => $trip->total_booking_fee, 'type' => 'Revenue'),
       	);
       	
       	Ledger::insert($insertLegderQuery);	   	
       } 
     }else if($totalPassengers <  10){
          $trip = Trip::create([
           'driver_id' => $driver_id,
           'origin' => $terminal->terminal_id,
           'terminal_id' => $terminals->terminal_id,
           'plate_number' => $plateNumber,
           'status' => 'Departed',
           'total_passengers' => $totalPassengers,
           'total_booking_fee' => $request->totalBookingFee,
           'community_fund' => $communityFund,
           'date_departed' => $request->dateDeparted,
           'time_departed' => $timeDepartedFormat,
           'report_status' => 'Accepted',
         ]);

    	if($terminals->terminal_id == Auth::user()->terminal_id){
    		Ledger::create([
	       		'description' => 'Booking Fee',
	       		'amount' => $trip->total_booking_fee,
	       		'type' => 'Revenue', 		
	       	]);
       	}        
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
            'terminal_id' => $terminals->terminal_id,
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
  return redirect('home/trip-log')->with('success', 'Report created successfully!'); 
  }
}
