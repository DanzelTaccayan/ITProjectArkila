<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Ticket;
use App\Van;
use App\Member;
use App\User;
use App\Terminal;
use App\Transaction;
use Carbon\Carbon;
use PDF;
use Illuminate\Validation\Rule;


class TripsController extends Controller
{


    public function updateQueueNumber(Trip $trip)
    {
        $tripsArr = [];
        $trips = Trip::whereNotNull('queue_number')->orderBy('queue_number')->get();


        $beingTransferredKey = $trip->queue_number;
        $beingReplacedKey = request('value');


        $beingTransferredVal = $trip->trip_id;
        $beingReplacedVal = Trip::where('queue_number',request('value'))->first()->trip_id;

        $tripsCount = Trip::whereNotNull('queue_number')->count();

        $this->validate(request(),[
            'value' => 'required|digits_between:1,'.$tripsCount,
        ]);

        for($i = 0,$n = 1; $i < count($trips) ; $i++,$n++) {
            $tripsArr[$n] =  $trips[$i]->trip_id;
        }


        $tripsArr[$beingReplacedKey] = $beingTransferredVal;


        if($beingTransferredKey > $beingReplacedKey){

            $beingReplacedKey += 1;

            for($i = $beingReplacedKey; $i<= $beingTransferredKey; $i++) {
                    $beingTransferredVal =  $tripsArr[$i];
                    $tripsArr[$i] = $beingReplacedVal;
                    $beingReplacedVal = $beingTransferredVal;

            }

            foreach($tripsArr as $queueNum => $tripId){
                $trip = Trip::find($tripId);

                $trip->update([
                    'queue_number' => $queueNum
                ]);
            }

        }else{

            $beingReplacedKey -= 1;


            for($i = $beingReplacedKey; $i>= $beingTransferredKey; $i--) {
                    $beingTransferredVal = $tripsArr[$i];
                    $tripsArr[$i] = $beingReplacedVal;
                    $beingReplacedVal = $beingTransferredVal;


            }

            foreach($tripsArr as $queueNum => $tripId){
                $trip = Trip::find($tripId);

                $trip->update([
                    'queue_number' => $queueNum
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trip $trip)
    {
        if($trip->queue_number){
            $trips = Trip::where('terminal_id',$trip->terminal_id)->get();
            foreach($trips as $tripObj){
                    if($tripObj->queue_number > $trip->queue_number){
                        $tripObj->update([
                            'queue_number' => $tripObj->queue_number-1
                        ]);
                    }
            }
        }
        $trip->delete();

        session()->flash('success', 'Trip Successfully Deleted');
        return back();
    }

    public function listSpecialUnits(Terminal $terminal)
    {
        $trips = $terminal->trips()->where('has_privilege',1)->get();
        return view('trips.partials.listSpecialUnits',compact('trips'));
    }

    public function updateVanQueue()
    {
        $vans = request('vanQueue');

        $tripArr = [];
        if(is_array($vans)) {
            foreach($vans[0] as $key => $vanInfo){

                if($van = Van::find($vanInfo['plate'])){
                    $van->updateQueue($key);
                }
            }

            $trips = Trip::whereNotNull('queue_number')->orderBy('queue_number')->get();

            foreach($trips as $trip){
                array_push($tripArr,
                    [
                        'trip_id' =>$trip->trip_id,
                       'plate_number' => $trip->plate_number,
                       'queue_number' => $trip->queue_number
                    ]);
            }
            return response()->json($tripArr);
        }
        else{
            return "Operator Not Found";
        }


    }

    public function putOnDeck(Trip $trip){
        $trips = Trip::where('terminal_id',$trip->terminal_id)->whereNotNull('queue_number')->get();

        foreach($trips as $tripObj){
            $newQueueNumber = ($tripObj->queue_number)+1;
            $tripObj->update([
                'queue_number' => $newQueueNumber
            ]);
        }

        $trip->update([
            'queue_number' => 1,
            'remarks' => null,
            'has_privilege' => 0
        ]);

        return back();
    }

    public function changeRemarksOB(Trip $trip)
    {
        $this->validate(request(),[
            'answer' => [Rule::in(['Yes', 'No'])]
        ]);

        if(request('answer') === 'Yes'){
            $trips = Trip::where('terminal_id',$trip->terminal_id)->get();
            foreach($trips as $tripObj){
                if($tripObj->queue_number > $trip->queue_number){
                    $tripObj->update([
                        'queue_number' => $tripObj->queue_number-1
                    ]);
                }
            }

            $trip->update([
                'queue_number' => NULL,
                'has_privilege' => 1
            ]);

        }else{
            $trip->update([
                'remarks' => NULL,
            ]);
        }
    }

    public function tripLog()
    {
        $trips = Trip::departed()->accepted()->get();
        $user = User::where('user_type','Super-admin')->first();
        $superAdmin = $user->terminal;
        return view('trips.tripLog', compact('trips', 'superAdmin'));
    }

    public function driverReport()
    {
        $trips = Trip::departed()->pending()->get();
        $user = User::where('user_type','Super-admin')->first();
        $superAdmin = $user->terminal;
        return view('trips.driverReport', compact('trips', 'superAdmin'));
    }

    public function viewReport(Trip $trip)
    {
        $destinations = Transaction::join('destination', 'destination.destination_id', '=', 'transaction.destination_id')->join('trip', 'trip.trip_id', '=', 'transaction.trip_id')->where('transaction.trip_id', $trip->trip_id)->selectRaw('transaction.trip_id as tripid, destination.description as destdesc, destination.amount as amount, COUNT(destination.description) as counts')->groupBy(['transaction.trip_id','destination.description'])->get();
        $user = User::where('user_type','Super-admin')->first();
        $superAdmin = $user->terminal;
        return view('trips.viewReport', compact('destinations', 'trip', 'superAdmin'));
    }

    public function listQueueNumbers(Terminal $terminal)
    {
            $tripsArr = [];
            $trips = $terminal->trips()->whereNotNull('queue_number')->get();

            foreach($trips as $trip){
                array_push($tripsArr,[
                   'value' =>  $trip->queue_number,
                    'text' => $trip->queue_number
                ]);
            }
            return $tripsArr;
        }

    public function acceptReport(Trip $trip)
    {
        $trip->update([
            "report_status" => 'Accepted',
        ]);

        $message = "Trip " . $trip->trip_id . " successfully accepted";
        return redirect(route('trips.tripLog'))->with('success', $message);
    }

    public function declineReport(Trip $trip)
    {
        $trip->update([
            "report_status" => 'Declined',
        ]);
        $message = "Trip " . $trip->trip_id . " successfully declined";
        return redirect(route('trips.driverReport'))->with('success', $message);
    }

    public function viewTripLog(Trip $trip)
    {
        $destinations = Transaction::join('destination', 'destination.destination_id', '=', 'transaction.destination_id')
        ->join('trip', 'trip.trip_id', '=', 'transaction.trip_id')
        ->where('transaction.trip_id', $trip->trip_id)
        ->selectRaw('transaction.trip_id as tripid, destination.description as destdesc, destination.amount as amount, COUNT(destination.description) as counts')
        ->groupBy(['transaction.trip_id','destination.description'])->get();
        $tickets = Transaction::join('ticket', 'transaction.ticket_id','=','ticket.ticket_id')
        ->where('trip_id',$trip->trip_id)->get();
        foreach($tickets as $ticket){
            if($ticket->type === "Discount"){

            }    
        }                            
        $user = User::where('user_type','Super-admin')->first();
        $superAdmin = $user->terminal;
        return view('trips.viewTrip', compact('destinations', 'trip', 'superAdmin'));
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
