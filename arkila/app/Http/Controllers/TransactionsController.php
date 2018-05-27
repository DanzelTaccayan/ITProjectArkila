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
use App\Reservation;
use DB;
use Response;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where('status', 'PAID')->get();
        $terminals = Destination::allTerminal()->get();
        $tickets = Ticket::all();
        $selectedTickets = SelectedTicket::all();
        return view('transaction.index',compact('terminals','tickets','selectedTickets', 'reservations'));
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
            'destination' => 'exists:destination,destination_id'
        ]);
        if(SelectedTicket::whereIn('ticket_id',Ticket::whereIn('destination_id',$destination->routeFromDestination->pluck('destination_id'))->get()->pluck('ticket_id'))->get()->count() > 0 ) {
            // Start transaction!
            DB::beginTransaction();
            try  {
                foreach (SelectedTicket::whereIn('ticket_id',Ticket::whereIn('destination_id',$destination->routeFromDestination
                    ->pluck('destination_id'))
                    ->get()
                    ->pluck('ticket_id'))
                             ->get() as $selectedTicket) {
                    $selectedTicket->ticket->update(['status'=>'Pending']);
                    $selectedTicket->delete();
                }

                DB::commit();
                return back()->with('success', 'Successfully, Sold tickets');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return back()->withErrors('There seems to be a problem. Please try again, If the problem persists please contact the administator');
            }

        } else {
            return back()->withErrors('Select Ticket/s first before selling');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Destination $destination
     * @return \Illuminate\Http\Response
     */
    public function depart(Destination $destination)
    {

        if ($vanOnQueue = $destination->vanQueue()->where('queue_number', 1)->first()) {
            if ($tickets = $destination->tickets->where('status','OnBoard')) {
                //Compute for the total passenger, booking fee, and community fund
                $totalPassengers = count($tickets);

                //Return Error
                if($totalPassengers >  $vanOnQueue->van->seating_capacity) {
                    return Response::json(['error' => 'Cannot Depart. The sold tickets exceeds the seating capacity of the van'], 422);
                } elseif ( $totalPassengers == 0 ) {
                    return Response::json(['error' => 'Cannot Depart. There are no sold tickets'], 422);
                }

                // Start transaction!
                DB::beginTransaction();
                try {
                    $totalBooking = ($destination->routeOrigin->first()->booking_fee) * $totalPassengers;
                    $totalCommunity = (Fee::where('description', 'Community Fund')->first()->amount) * $totalPassengers;

                    //Since SOP would only be applied to vans that has loaded 10 and more passengers
                    if ($totalPassengers >= 10) {
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
                        'destination' => $vanOnQueue->destination->destination_name,
                        'origin' => $destination->routeOrigin->first()->destination_name,
                        'total_passengers' => $totalPassengers,
                        'total_booking_fee' => $totalBooking,
                        'community_fund' => $totalCommunity,
                        'SOP' => $sop,
                        'date_departed' => $dateDeparted,
                        'report_status' => 'Accepted',
                        'time_departed' => $dateDeparted->hour . ':' . $dateDeparted->minute . ':' . $dateDeparted->second
                    ]);


                    Ledger::create([
                        'description' => 'Booking Fee',
                        'amount' => $totalBooking,
                        'type' => 'Revenue'
                    ]);
                    $vanOnQueue->delete();
                    //Check if the Van has less than 10 passengers; if it has less than 10 then ask if it would be marked as OB
                    if ($totalPassengers <= 10) {
                        if (VanQueue::where('destination_id', $destination->destination_id)->whereNotNull('queue_number')->first() ?? null) {
                            $queueNumber = VanQueue::where('destination_id', $destination->destination_id)->orderBy('queue_number', 'desc')->first()->queue_number + 1;

                        } else {
                            $queueNumber = 1;

                        }

                        VanQueue::create([
                            'destination_id' => Destination::where('destination_name', $trip->destination)->first()->destination_id,
                            'driver_id' => $trip->driver_id,
                            'van_id' => $trip->van_id,
                            'remarks' => 'OB',
                            'has_privilege' => 0,
                            'queue_number' => $queueNumber
                        ]);


                    }

                    //Insert the departed tickets into the transaction table and then make the tickets available
                    foreach ($tickets as $ticket) {
                        Transaction::create([
                            'ticket_name' => $ticket->ticket_number,
                            'trip_id' => $trip->trip_id,
                            'destination' => $vanOnQueue->destination->destination_name,
                            'origin' => $destination->routeOrigin->first()->destination_name,
                            'amount_paid' => $ticket->fare,
                            'status' => 'Departed'
                        ]);

                        $ticket->update([
                            'status' => null
                        ]);
                    }

                    //Update the queue in the van queue
                    $queue = $destination->vanQueue()->whereNotNull('queue_number')->get();
                    if (count($queue) > 1) {
                        foreach ($queue as $trip) {
                            $tripQueueNum = ($trip->queue_number) - 1;
                            $trip->update([
                                'queue_number' => $tripQueueNum
                            ]);
                        }
                    }

                    DB::commit();
                    session()->flash('success', 'Successfully departed '.$trip->van->plate_number);
                } catch (\Exception $e) {
                    DB::rollback();
                    return back()->withErrors('There seems to be a problem. Please try again, if the problem persists please contact the administrator');
                }

            }
        }
        return 'Failed';
    }

    public function updatePendingTransactions()
    {
        //UpdatePending
        if($tickets = request('tickets')) {
            $this->validate(request(),[
                'tickets.*' => 'required|exists:ticket,ticket_id'
            ]);

            // Start transaction!
            DB::beginTransaction();
            try  {
                $seatingCapacity = VanQueue::where('destination_id',Ticket::find($tickets[0])->destination->destination_id)
                    ->where('queue_number',1)
                    ->first()
                    ->van
                    ->seating_capacity;

                if($seatingCapacity >= count($tickets)) {
                    foreach($tickets as $ticketId) {
                        $ticket = Ticket::find($ticketId);
                        if(is_null($ticket->status) || $ticket->status == "OnBoard") {
                            DB::rollback();
                            if(is_null($ticket->status)) {
                                return Response::json(['error' => 'There is a given ticket that is unsold'],422);
                            } else {
                                return Response::json(['error' => 'There is a given ticket that is already On Board'],422);
                            }
                        }

                        $ticket->update([
                            'status' => 'OnBoard'
                        ]);
                    }

                    DB::commit();
                    return 'success';
                } else {
                    return Response::json(['error' => 'The tickets boarded is greater then the seating capacity of the van on deck'],422);
                }

            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
            }

        } else {
            return Response::json(['error' => 'error no transaction given'],422);
        }

    }

    public function updateOnBoardTransactions()
    {
        if($tickets = request('tickets')) {
            $this->validate(request(),[
                'tickets.*' => 'required|exists:ticket,ticket_id'
            ]);

            // Start transaction!
            DB::beginTransaction();
            try  {
                foreach($tickets as $ticketId) {
                    $ticket = Ticket::find($ticketId);

                    if(is_null($ticket->status) || $ticket->status == "Pending") {
                        DB::rollback();
                        if(is_null($ticket->status)) {
                            return Response::json(['error' => 'There is a given ticket that is unsold'],422);
                        } else {
                            return Response::json(['error' => 'There is a given ticket that is already Pending'],422);
                        }
                    }

                    $ticket->update([
                        'status' => 'Pending'
                    ]);
                }
                DB::commit();
                return 'success';
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
            }
        } else {
            return Response::json(['error' => 'error no transaction given'],422);
        }
    }

    public function manage()
    {
        return view('transaction.managetickets');
    }

    public function listSourceDrivers()
    {
        $drivers = [];

        foreach(Member::where('status','Active')->whereNotNull('license_number')->whereNotIn('member_id',VanQueue::all()->pluck('driver_id'))->get() as $member){
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

        DB:beginTransaction();
        try{
            $vanOnQueue->update([
                'driver_id' => request('value')
            ]);
            DB::commit();
            return 'success';
        } catch(\Exception $e) {
            DB::rollback;
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }

    }

    //Refund
    public function refund(Ticket $ticket)
    {
        if(is_null($ticket->status)) {
            return Response::json(['error' => 'The ticket to be refunded is not sold'],422);
        }
        // Start transaction!
        DB::beginTransaction();
        try  {
            $ticket->update([
                'status' => null
            ]);

            Transaction::create([
                'ticket_name' => $ticket->ticket_number,
                'destination' => $ticket->destination->destination_name,
                'origin' => $ticket->destination->routeOrigin->first()->destination_name,
                'amount_paid' => $ticket->fare,
                'status' => 'Refunded'
            ]);

            DB::commit();
            return 'success';
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }

    }

    public function multipleRefund()
    {
        $ticketObjArr = [];
        $responseArr = [];
        $this->validate(request(),[
            'refund.*' => 'exists:ticket,ticket_id'
        ]);

        foreach(request('refund') as $ticketId)
        {
            $ticketObj = Ticket::find($ticketId);
            if(is_null($ticketObj)) {
                return Response::json(['error' => 'There is a given ticket that does not exist'], 422);
            } else {
                if(is_null($ticketObj->status)) {
                    return Response::json(['error' => 'There is a given ticket to be refunded that is not sold'],422);
                }

                array_push($ticketObjArr, $ticketObj);

            }
        }

        //Begin Transaction
        DB::beginTransaction();
        try {
            foreach($ticketObjArr as $ticket)
            {

                $ticket->update([
                    'status' => null
                ]);

                Transaction::create([
                    'ticket_name' => $ticket->ticket_number,
                    'destination' => $ticket->destination->destination_name,
                    'origin' => $ticket->destination->routeOrigin->destination_name,
                    'amount_paid' => $ticket->fare,
                    'status' => 'Refunded'
                ]);

                array_push($responseArr, $ticket->ticket_number);
            }
            return implode(' ',$responseArr);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }


    }

    //Lost
    public function lost(Ticket $ticket) {
        if(is_null($ticket->status)) {
            return Response::json(['error' => 'The given lost ticket is not sold'],422);
        }

        //Being Transaction
        DB::beginTransaction();
        try{
            $ticket->update([
                'status' => null
            ]);

            Ledger::create([
                'description' => 'Lost/Expire Ticket',
                'amount' => $ticket->fare,
                'type' => 'Revenue'
            ]);

            Transaction::create([
                'ticket_name' => $ticket->ticket_number,
                'destination' => $ticket->destination->destination_name,
                'origin' => $ticket->destination->routeOrigin->first()->destination_name,
                'amount_paid' => $ticket->fare,
                'status' => 'Lost/Expired'
            ]);

            DB::commit();
            return $ticket->ticket_number;
        } catch (\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }

    }

    //Delete
    public function destroy(Ticket $ticket)
    {
        if(is_null($ticket->status)) {
            return Response::json(['error' => 'The given ticket to be cancelled is unsold'],422);
        }

        DB::beginTransaction();
        try {
            $ticket->update([
                'status' => null
            ]);
            DB::commit();
            return $ticket->ticket_number;
        } catch(\Exception $e) {
            DB::rollback();
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }
    }

    public function multipleDelete()
    {
        $ticketObjArr = [];
        $responseArr = [];

        $this->validate(request(),[
            'delete.*' => 'exists:ticket,ticket_id'
        ]);
        foreach(request('delete') as $ticketId)
        {
            $ticketObj = Ticket::find(ticketId);
            if(is_null($ticketObj)) {
                return Response::json(['error' => 'There is a given ticket that does not exist'],422);
            } else {
                if(is_null($ticketObj->status)) {
                    return Response::json(['error' => 'There is a given ticket to be cancelled that is not sold'],422);
                }

                array_push($ticketObjArr, Ticket::find($ticketId));
            }

        }

        //Start Transaction
        DB::beginTransaction();
        try {
            foreach($ticketObjArr as $ticket)
            {
                $ticket->update([
                    'status' => null
                ]);

                array_push($responseArr, $ticket->ticket_number);
            }
            DB::commit();
            return implode(" ",$responseArr);
        } catch(\Exception $e) {
            DB::rollback();
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }

    }


    //Selected Ticket
    public function selectTicket(Destination $destination)
    {
        if(request('ticketType') === "Regular" || request('ticketType') === "Discount") {
            $ticketType = request('ticketType');
            $ticket = $destination->tickets()->where('type',$ticketType)->whereNull('status')->whereNotIn('ticket_id', $destination->selectedTickets->pluck('ticket_id'))->first();
            if(is_null($ticket)) {
                return Response::json(['error' => 'There are no more tickets left, please add another to select a ticket'], 422);
            }

            // Start transaction!
            DB::beginTransaction();
            try  {
                $selectedTicket = SelectedTicket::create([
                    'ticket_id' => $ticket->ticket_id,
                ]);

                $responseArr = ['ticketNumber' => $selectedTicket->ticket->ticket_number, 'fare' => $selectedTicket->ticket->fare,'selectedId' => $selectedTicket->selected_ticket_id];


                DB::commit();
                return response()->json($responseArr);

            } catch(\Exception $e) {
                \Log::info($e);
                DB::rollback();
                return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
            }

        } else {
            return Response::json(['error' => 'Invalid Ticket Type'],422);
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
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
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
            return Response::json(['error' => 'There seems to be a problem. Please try again, If the problem persists please contact the administator'],422);
        }
    }
}
