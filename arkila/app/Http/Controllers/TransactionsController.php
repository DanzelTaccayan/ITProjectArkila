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
use App\Fee;
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
        $terminals = Destination::where('is_main_terminal','!=',1)->where('is_terminal',1)->get();
        $destinations = Destination::where('is_main_terminal','!=',1)->get();

        return view('transaction.managetickets',compact('terminals','destinations'));
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

                    $selectedTicket->ticket->update(['is_sold'=>'1']);
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
    public function depart(Destination $destination) {
        if( $vanOnQueue = $destination->vanQueue()->where('queue_number',1)->first() ) {
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);

            // Start transaction!
            DB::beginTransaction();
            try {
                //Compute for the total passenger, booking fee, and community fund
                $totalPassengers = count(request('transactions'));
                $totalBooking = ($destination->routeOrigin->first()->booking_fee) * $totalPassengers;
                $totalCommunity = (Fee::where('description', 'Community Fund')->first()->amount) * $totalPassengers;

                //Since SOP would only be applied to vans that has loaded 10 and more passengers
                if($totalPassengers >= 10) {
                    $sop = (Fee::where('description', 'SOP')->first()->amount);

                    Ledger::create([
                        'description' => 'SOP',
                        'amount' => $sop,
                        'type' => 'Revenue'
                    ]);

                } else {
                    $sop = null;
                }

                //Depart the Van
                $dateDeparted = Carbon::now(new DateTimeZone('Asia/Manila'));
                $trip = Trip::create([
                    'driver_id' => $vanOnQueue->driver_id,
                    'van_id' => $vanOnQueue->van_id,
                    'destination'=> $vanOnQueue->destination->destination_name,
                    'origin'=>$destination->routeOrigin->first()->destination_name,
                    'total_passengers' => $totalPassengers,
                    'total_booking_fee' => $totalBooking,
                    'community_fund' => $totalCommunity,
                    'SOP' => $sop,
                    'date_departed' => $dateDeparted,
                    'report_status' => 'Accepted',
                    'time_departed' => $dateDeparted->hour.':'.$dateDeparted->minute.':'.$dateDeparted->second
                ]);


                Ledger::create([
                    'description' => 'Booking Fee',
                    'amount' => $totalBooking,
                    'type' => 'Revenue'
                ]);
                $vanOnQueue->delete();
                //Check if the Van has less than 10 passengers; if it has less than 10 then ask if it would be marked as OB
                if($totalPassengers <= 10) {
                    if(VanQueue::where('destination_id',$destination->destination_id)->whereNotNull('queue_number')->first() ?? null) {
                        $queueNumber = VanQueue::where('destination_id',$destination->destination_id)->orderBy('queue_number','desc')->first()->queue_number+1;

                    } else {
                        $queueNumber = 1;

                    }

                    VanQueue::create([
                        'destination_id' => Destination::where('destination_name',$trip->destination)->first()->destination_id,
                        'driver_id' => $trip->driver_id,
                        'van_id' => $trip->van_id,
                        'remarks' => 'OB',
                        'has_privilege' => 1,
                        'queue_number' => $queueNumber
                    ]);


                }

                //Update each Transactions, make them unavailable and update their status to departed
                foreach(request('transactions') as $transactionId) {
                    $transaction = Transaction::find($transactionId);

                    $transaction->update([
                        'status' => 'Departed',
                        'trip_id' => $trip->trip_id
                    ]);

                    $transaction->ticket->update([
                        'is_sold' => '1'
                    ]);
                }

                //Update the queue in the van queue
                $queue = $destination->vanQueue()->whereNotNull('queue_number')->get();
                if(count($queue) > 1) {
                    foreach ( $queue as $trip) {
                        $tripQueueNum = ($trip->queue_number) - 1;
                        $trip->update([
                            'queue_number' => $tripQueueNum
                        ]);
                    }
                }

                DB::commit();
                return 'success';
            } catch(\Exception $e) {
                DB::rollback();
                return back()->withErrors('There seems to be a problem. Please try again, if the problem persists please contact the administrator');
            }

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

            // Start transaction!
            DB::beginTransaction();
            try  {
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

                    DB::commit();
                    return 'success';
                }
                else {
                    return 'The tickets boarded is greater than the seating capacity of the van on deck';
                }

            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administator');
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

            // Start transaction!
            DB::beginTransaction();
            try  {
                foreach(request('transactions') as $transactionId) {
                    $transaction = Transaction::find($transactionId);
                    $transaction->update([
                        'status' => 'Pending',
                        'trip_id' => null
                    ]);
                }

                DB::commit();
                return 'success';
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administator');
            }
        } else {
            return 'error no transaction given';
        }
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

    public function changeDriver(VanQueue $vanOnQueue)
    {
        $this->validate(request(),[
           'value' => 'exists:member,member_id'
        ]);

        $vanOnQueue->update([
           'driver_id' => request('value')
        ]);

        return 'success';
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

    public function changeDestination(Transaction $transaction)
    {
        $this->validate(request(),[
            'changeDestination' => 'required|exists:destination,destination_id'
        ]);
        $newTicket = Ticket::where('destination_id',request('destination'))->where('is_sold',0)->first();

        $transaction->update([
            'destination'=> $newTicket->destination->destination_name,
            'ticket_id' => $newTicket->ticket_id
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


    //Selected Ticket
    public function selectTicket(Destination $destination)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            if(request('ticketType') === "Regular" || request('ticketType') === "Discount") {
                $ticketType = request('ticketType');
                $ticket = $destination->tickets->where('type',$ticketType)->where('is_sold',0)->whereNotIn('ticket_id', $destination->selectedTickets->pluck('ticket_id'))->first();
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
