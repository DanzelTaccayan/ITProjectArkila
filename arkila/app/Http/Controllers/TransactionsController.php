<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Ledger;
use App\SelectedTicket;
use App\Trip;
use App\Transaction;
use App\Ticket;
use App\VanQueue;
use Carbon\Carbon;
use App\Member;
use DateTimeZone;
use DB;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $terminals = Destination::where('is_main_terminal','!=','1')->get();
        $transactions = Transaction::all();
        $selectedTickets = SelectedTicket::all();
        return view('transaction.index',compact('terminals','transactions','selectedTickets'));
    }

    public function manageTickets()
    {
        $terminals = Destination::whereNotIn('is_main_terminal','!=','1')->get();

        return view('transaction.managetickets',compact('terminals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Destination $destination
     * @return \Illuminate\Http\Response
     */
    public function store(Destination $destination) {
        $this->validate(request(),[
            'destination' => 'exists:destination,destination_id',
            'ticket.*' => 'exists:ticket,ticket_id'
        ]);

// Start transaction!
        DB::beginTransaction();
        try  {
            if(SelectedTicket::whereIn('ticket_id',Ticket::whereIn('destination_id',$destination->routeFromDestination->pluck('destination_id'))->get()->pluck('ticket_id'))->get()->count() > 0 ) {
                foreach (SelectedTicket::whereIn('ticket_id',Ticket::whereIn('destination_id',$destination->routeFromDestination
                    ->pluck('destination_id'))
                    ->get()
                    ->pluck('ticket_id'))
                             ->get() as $selectedTicket) {

                    Transaction::create([
                        'ticket_id' => $selectedTicket->ticket_id,
                        'destination' => $selectedTicket->ticket->destination->destination_name,
                        'origin' => $selectedTicket->ticket->destination->routeOrigin->first()->destination_name,
                        'amount_paid' => $selectedTicket->ticket->fare,
                        'status' => 'Pending'
                    ]);

                    $selectedTicket->delete();
                }

                DB::commit();
                return back();
            } else {
                return back()->withErrors('Select Ticket/s first before selling');
            }
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administator');
        }


    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Destination $terminal) {
        if( $trip = $terminal->vanQueue()->where('queue_number',1)->first() )
        {
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);
            $totalPassengers = count(request('transactions'));


            $totalBooking = (Destination::find(auth()->user()->terminal_id)->booking_fee) * $totalPassengers;


            $totalCommunity = (Fee::where('description', 'Community Fund')->first()->amount) * $totalPassengers;

            if($totalPassengers >= 10)
            {
                $sop = 100;

                Ledger::create([
                    'description' => 'SOP',
                    'amount' => $sop,
                    'type' => 'Revenue'
                ]);

            }
            else
            {
                $sop = null;
            }
            $dateDeparted = Carbon::now(new DateTimeZone('Asia/Manila'));
            $trip->update([
                'status' => 'Departed',
                'total_passengers' => $totalPassengers,
                'total_booking_fee' => $totalBooking,
                'community_fund' => $totalCommunity,
                'SOP' => $sop,
                'date_departed' => $dateDeparted,
                'queue_number' => null,
                'report_status' => 'Accepted',
                'time_departed' => $dateDeparted->hour.':'.$dateDeparted->minute.':'.$dateDeparted->second
            ]);


            Ledger::create([
                'description' => 'Booking Fee',
                'amount' => $totalBooking,
                'type' => 'Revenue'
            ]);


            if($totalPassengers <= 10)
            {
                if(Trip::where('terminal_id',$terminal->terminal_id)->whereNotNull('queue_number')->first() ?? null)
                {
                    $queueNumber = Trip::where('terminal_id',$terminal->terminal_id)->orderBy('queue_number','desc')->first()->queue_number+1;

                }
                else
                {
                    $queueNumber = 1;

                }

                Trip::create([
                    'driver_id' => $trip->driver_id,
                    'terminal_id' => $trip->terminal_id,
                    'plate_number' => $trip->plate_number,
                    'remarks' => 'OB',
                    'status' => 'On Queue',
                    'queue_number' => $queueNumber
                ]);

            }


            foreach(request('transactions') as $transactionId)
            {
                $transaction = Transaction::find($transactionId);

                        $transaction->update([
                            'status' => 'Departed',
                            'trip_id' => $trip->trip_id
                        ]);

                        $transaction->ticket->update([
                           'isAvailable' => '1'
                        ]);
            }

            foreach($trips = $terminal->trips()->whereNotNull('queue_number')->get() as $trip)
            {
                if(count($trips) > 1)
                {
                    $tripQueueNum = ($trip->queue_number)-1;
                    $trip->update([
                       'queue_number' => $tripQueueNum
                    ]);
                }
            }

            return 'success';
        }
        return 'Failed';
    }

    public function updatePendingTransactions()
    {
        //UpdatePending
        if(request('transactions')) {
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);

            $seatingCapacity = VanQueue::where('destination_id',Destination::where('destination_name',Transaction::find(request('transactions')[0])->destination)->first()->destination_id)
            ->where('queue_number',1)
            ->first()
            ->van
            ->seating_capacity;

            if($seatingCapacity >= count(request('transactions'))) {
                foreach(request('transactions') as $transactionId) {
                    $transaction = Transaction::find($transactionId);
                    $transaction->update([
                        'status' => 'OnBoard',
                        'trip_id' => null
                    ]);
                }

                return 'success';
            }
            else {
                return 'The tickets boarded is greater than the seating capacity of the van on deck';
            }

        } else {
            return 'error no transaction given';
        }

    }


    public function updateOnBoardTransactions()
    {
        if(request('transactions')) {
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);

            foreach(request('transactions') as $transactionId) {
                $transaction = Transaction::find($transactionId);
                $transaction->update([
                    'status' => 'Pending',
                    'trip_id' => null
                ]);
            }

            return 'success';
        } else {
            return 'error no transaction given';
        }

    }

    public function changeDestination(Transaction $transaction)
    {
        $this->validate(request(),[
            'changeDestination' => 'required|exists:destination,destination_id'
        ]);

        $transaction->update([
            'destination_id'=> request('changeDestination')
        ]);
        return 'success';
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $this->validate(request(),[
            'delete' => 'exists|ticket,ticket_id'
        ]);

        $transaction->update([
            'status' => 'Deleted'
        ]);

        //put transaction into ledger
        if($transaction->ticket->type === 'Discount')
        {
                $discount = (FeesAndDeduction::find(2)->amount/100)*$transaction->destination->amount;
        }
        else
        {
                $discount = 0;
        }
        $computedAmount = $transaction->destination->amount - $discount;
        Ledger::create([
            'description' => 'Expired Ticket',
            'amount' => $computedAmount,
            'type' => 'Revenue'
        ]);

        $transaction->ticket->update([
           'isAvailable' => 1
        ]);

        return 'success';
    }

    public function multipleDelete()
    {
        $transactionObjArr = [];
        $this->validate(request(),[
            'delete.*' => 'exists:transaction,transaction_id'
        ]);


        foreach(request('delete') as $transactionId)
        {
            array_push($transactionObjArr, Transaction::find($transactionId));
        }

        foreach($transactionObjArr as $transaction)
        {

            $transaction->update([
                'status' => 'Deleted'
            ]);

            //put transaction into ledger
            if($transaction->ticket->type === 'Discount')
            {
                $discount = (FeesAndDeduction::find(2)->amount/100)*$transaction->destination->amount;
            }else
            {
                $discount = 0;
            }

            $computedAmount = ($transaction->destination->amount) - $discount;
            Ledger::create([
                'description' => 'Expired Ticket',
                'amount' => $computedAmount,
                'type' => 'Revenue'
            ]);

            $transaction->ticket->update([
                'isAvailable' => 1
            ]);

        }
        return 'success';
    }

    public function listDestinations(Destination $terminal)
    {
        $destinationArr = [];

        foreach($terminal->destinations as $destination)
        {
            array_push($destinationArr,[
                'id'=> $destination->destination_id,
                'description' => $destination->description
            ]);
        }

        return response()->json($destinationArr);
    }

    public function listDiscountedTickets(Destination $destination)
    {
        $ticketsArr = [];
        $tickets = $destination
            ->tickets()
            ->where('isAvailable', 1)
            ->where('type','Discount')
            ->orderBy('ticket_id','asc')
            ->get();

        foreach($tickets as $ticket){
            array_push($ticketsArr,[
                'id' => $ticket->ticket_id,
                'ticket_number' => $ticket->ticket_number
            ]);
        }

        return response()->json($ticketsArr);
    }

    public function listTickets(Destination $destination)
    {
        $ticketsArr = [];
        $tickets = $destination
            ->tickets()
            ->where('isAvailable', 1)
            ->where('type','Regular')
            ->orderBy('ticket_id','asc')
            ->get();

        foreach($tickets as $ticket){
            array_push($ticketsArr,[
                'id' => $ticket->ticket_id,
                'ticket_number' => $ticket->ticket_number
            ]);
        }

        return response()->json($ticketsArr);
    }

    public function manage()
    {
        return view('transaction.managetickets');
    }
    public function listSourceDrivers()
    {
        $drivers = [];

        foreach(Member::where('status','Active')->whereNotNull('license_number')->get() as $member){
            array_push($drivers,[
                'value' => $member->member_id,
                    'text' => $member->full_name
                ]
            );
        }

        return response()->json($drivers);

    }

    public function changeDriver(Trip $trip)
    {
        $this->validate(request(),[
           'value' => 'exists:member,member_id'
        ]);

        $trip->update([
           'driver_id' => request('value')
        ]);

        return 'success';
    }

    public function getTicketManagementPartial(Destination $terminal)
    {
        return view('transaction.managetickets',compact('terminal'));
    }

    public function refund(Transaction $transaction)
    {
        $transaction->update([
            'status' => 'Refunded'
        ]);

        $transaction->ticket->update([
            'isAvailable' => 1
        ]);

        return 'success';
    }

    //Selected Ticket
    public function selectTicket(Destination $destination)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            if(request('ticketType') === "Regular" || request('ticketType') === "Discount") {
                $ticketType = request('ticketType');
                $ticket = $destination->tickets->where('type',$ticketType)->whereNotIn('ticket_id', $destination->selectedTickets->pluck('ticket_id'))->first();
                if(is_null($ticket)) {
                    return \Response::json(['error' => 'There are no more tickets left, please add anotehr to select a ticket'], 422);
                }

                $selectedTicket = SelectedTicket::create([
                    'ticket_id' => $ticket->ticket_id,
                ]);

                $responseArr = ['ticketNumber' => $selectedTicket->ticket->ticket_number, 'fare' => $selectedTicket->ticket->fare,'selectedId' => $selectedTicket->selected_ticket_id];


                DB::commit();
                return response()->json($responseArr);
            }
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administator');
        }
    }

    public function deleteSelectedTicket(SelectedTicket $selectedTicket)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            $responseArr = ['destinationId' =>$selectedTicket->ticket->destination->destination_id,
                'terminalId'=> $selectedTicket->ticket->destination->routeDestination->first()->destination_id ,
                'ticketType'=> $selectedTicket->ticket->type,
                'fare' => $selectedTicket->ticket->fare
            ];

            $selectedTicket->delete();
            DB::commit();

            return response()->json($responseArr);
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administator');
        }

    }

    public function deleteLastSelectedTicket(Destination $destination)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            if(request('ticketType') === 'Regular' || request('ticketType') === 'Discount') {

                $ticketType = request('ticketType');
                $lastTicket =$destination->selectedtickets()
                    ->orderBy('selected_ticket_id','desc')
                    ->where('type', $ticketType)
                    ->first();

                $response_arr = [
                    'lastSelected' => $lastTicket->selected_ticket_id,
                    'fare'=> $lastTicket->ticket->fare
                ];

                $lastTicket->delete();

                DB::commit();
                return response()->json($response_arr);
            }

        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administrator');
        }
    }
}
