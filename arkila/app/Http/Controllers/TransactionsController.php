<?php

namespace App\Http\Controllers;

use App\Destination;
use App\Ledger;
use App\SelectedTicket;
use App\SoldTicket;
use App\Trip;
use App\Transaction;
use App\Ticket;
use App\VanQueue;
use Carbon\Carbon;
use App\Member;
use DateTimeZone;
use App\Fee;
use App\Reservation;
use Response;
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
        $reservations = Reservation::where('status', 'PAID')->get();
        $terminals = Destination::allTerminal()->get();
        $soldTickets = SoldTicket::orderBy('created_at','asc')->get();
        $selectedTickets = SelectedTicket::all();
        return view('transaction.index',compact('terminals','soldTickets','selectedTickets', 'reservations'));
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

        if(SelectedTicket::where('selected_from_terminal',$destination->destination_id)->get()->count() > 0 ) {

            if(request('customer') != null) {
                $reservationId = request('customer');
                $reservation = Reservation::find(request('customer'));
            } else {
                $reservationId = null;
            }
            // Start transaction!
            DB::beginTransaction();
            try  {
                foreach (SelectedTicket::where('selected_from_terminal',$destination->destination_id)->get() as $selectedTicket) {

                    SoldTicket::create([
                        'ticket_id' => $selectedTicket->ticket->ticket_id,
                        'amount_paid' => $selectedTicket->ticket->fare,
                        'reservation_id' => $reservationId,
                        'boarded_at' => null
                    ]);

                    $selectedTicket->delete();
                }

                if($reservationId != null){
                    $reservation->update([
                        'status' => 'TICKET ON HAND',
                    ]);                    
                }

                DB::commit();
                session()->flash('success', 'Successfully, Sold tickets');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);

                return Response::json(['error' => 'Oops! Something went wront on the server. If the problem persists contact the administrator'], 422);
            }

        } else {
            return Response::json(['error' => 'Select Ticket/s first before selling'], 422);
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
        if($vanOnQueue = $destination->vanQueue()->where('queue_number',1)->first()) {
            if( $vanOnQueue->status == "ER" || $vanOnQueue->status == "CC") {
                return Response::json(['error' => 'The van on queue for terminal '.$destination->destination_name.' has a remark of '.$vanOnQueue->status.', please move the van to the special units list or change its remark'], 422);

            } else {
                if ($soldTickets = SoldTicket::where('boarded_at',$destination->destination_id)->get()) {
                    //Compute for the total passenger, booking fee, and community fund
                    $totalPassengers = count($soldTickets);

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
                            'time_departed' => $dateDeparted->hour . ':' . $dateDeparted->minute . ':' . $dateDeparted->second,
                            'reported_by' => 'Super-Admin'
                        ]);


                        Ledger::create([
                            'description' => 'Booking Fee',
                            'amount' => $totalBooking,
                            'type' => 'Revenue'
                        ]);

                        //Insert the departed tickets into the transaction table and then make the tickets available
                        foreach ($soldTickets as $soldTicket) {
                            Transaction::create([
                                'ticket_name' => $soldTicket->ticket->ticket_number,
                                'trip_id' => $trip->trip_id,
                                'destination' => $vanOnQueue->destination->destination_name,
                                'origin' => $destination->routeOrigin->first()->destination_name,
                                'amount_paid' => $soldTicket->amount_paid,
                                'transaction_ticket_type' => $soldTicket->ticket->type,
                                'status' => 'Departed'
                            ]);

                            if($soldTicket->reservation_id != null) {
                                $reservation = Reservation::find($soldTicket->reservation_id);
                                $reservation->update([
                                    'status' => 'DEPARTED',
                                    'is_refundable' => false,
                                ]);
                            }
                            $soldTicket->delete();
                        }

                        $vanOnQueue->delete();

                        //Update the queue in the van queue
                        $queue = $destination->vanQueue()->whereNotNull('queue_number')->get();
                        if (count($queue) > 0) {
                            foreach ($queue as $van) {
                                $tripQueueNum = ($van->queue_number) - 1;
                                $van->update([
                                    'queue_number' => $tripQueueNum
                                ]);
                            }
                        }

                        //Check if the Van has less than 10 passengers; if it has less than 10 then ask if it would be marked as OB
                        if ($totalPassengers < 10) {
                            if ($destination->vanQueue()->whereNotNull('queue_number')->count()) {
                                $queueNumber = $destination->vanQueue()->whereNotNull('queue_number')->orderBy('queue_number', 'desc')->first()->queue_number + 1;
                            } else {
                                $queueNumber = 1;
                            }

                            VanQueue::create([
                                'destination_id' => $destination->destination_id,
                                'driver_id' => $trip->driver_id,
                                'van_id' => $trip->van_id,
                                'remarks' => 'OB',
                                'has_privilege' => 0,
                                'queue_number' => $queueNumber
                            ]);

                        }

                        DB::commit();
                        session()->flash('success', 'Van with plate #'.$trip->van->plate_number.' has successfully departed');
                        return $trip->trip_id;
                    } catch (\Exception $e) {
                        DB::rollback();
                        \Log::info($e);
                        return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
                    }

                }

            }

        } else {
            return Response::json(['error' => 'There is no van on queue for Terminal '.$destination->destination_name.', please add one to depart passengers'], 422);

        }

    }

    public function updatePendingTransactions()
    {
        //UpdatePending
        if($soldTickets = request('soldTickets')) {
            $this->validate(request(),[
                'soldTickets.*' => 'required|exists:sold_ticket,sold_ticket_id'
                ,'destination' => 'required|exists:destination,destination_id'
            ]);

            $destinationId = request('destination');
            // Start transaction!
            DB::beginTransaction();
            try  {
                $seatingCapacity = VanQueue::where('destination_id',$destinationId)
                    ->where('queue_number',1)
                    ->first()
                    ->van
                    ->seating_capacity;

                $futureCount =intval(SoldTicket::where('boarded_at',$destinationId)->count()) + intval(count($soldTickets));

                if($seatingCapacity >= $futureCount ) {
                    foreach($soldTickets as $soldId) {
                        $soldTicket = SoldTicket::find($soldId);
                        if(is_null($soldTicket)) {
                            DB::rollback();
                            return Response::json(['error' => 'There is a given ticket that is unsold'],422);
                        } elseif (!is_null($soldTicket->boarded_at)) {
                            DB::rollback();
                            return Response::json(['error' => 'There is a given ticket that is already On Board'],422);
                        } else {
                            $soldTicket->update([
                                'boarded_at' => $destinationId
                            ]);
                        }
                    }
                } else {
                    DB::rollback();
                    return Response::json(['error' => 'The tickets to be boarded would exceed the seating capacity of the van on deck'],422);
                }
                DB::commit();
                return 'success';
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
            }

        } else {
            return Response::json(['error' => 'error no transaction given'],422);
        }

    }

    public function updateOnBoardTransactions()
    {

        $responseArr = [];

        if($soldTickets = request('soldTickets')) {
            $this->validate(request(),[
                'soldTickets.*' => 'required|exists:ticket,ticket_id'
            ]);

            // Start transaction!
            DB::beginTransaction();
            try  {
                foreach($soldTickets as $soldTicketId) {
                    $soldTicket = SoldTicket::find($soldTicketId);
                    if(is_null($soldTicket)) {
                        DB::rollback();
                        return Response::json(['error' => 'There is a given ticket that is not sold'],422);
                    } elseif(is_null($soldTicket->boarded_at)) {
                        DB::rollback();
                        return Response::json(['error' => 'There is a given ticket that is already Pending'],422);
                    } else {
                        $boardedId = $soldTicket->boarded_at;
                        $soldTicket->update([
                            'boarded_at' => null
                        ]);

                        $destinations = $soldTicket->ticket->destination->routeDestination;
                        if(count($destinations) > 1) {
                            $responseArr[$soldTicketId] = [];

                            foreach($destinations as $destination) {
                                if($destination->destination_id != $boardedId) {
                                    array_push($responseArr[$soldTicketId], $destination->destination_id);
                                }
                            }
                        }
                    }

                }
                DB::commit();
                return Response::json($responseArr);
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
            }
        } else {
            return Response::json(['error' => 'error no transaction given'],422);
        }
    }

    public function listSourceDrivers($driverOnVan)
    {
        $drivers = [];

        foreach(Member::whereNotIn('member_id', function($query) {
                $query->select('driver_id')->from('van_queue');
            })
            ->whereNotIn('member_id', Member::all()->where('license_number','IS', NULL)->pluck('member_id'))
            ->where('status','Active')->get() as $member) {

            array_push($drivers,[
                'value' => $member->member_id,
                    'text' => $member->full_name
                ]
            );
        }
        if($vanOnQueueDriver = Member::find($driverOnVan)) {
            array_push($drivers, [
                'value' => $vanOnQueueDriver->member_id,
                'text' => $vanOnQueueDriver->full_name
            ]);
        }
        return response()->json($drivers);

    }

    public function changeDriver(VanQueue $vanOnQueue)
    {
        $this->validate(request(),[
            'value' => 'exists:member,member_id'
        ]);

        DB::beginTransaction();
        try{
            $vanOnQueue->update([
                'driver_id' => request('value')
            ]);
            DB::commit();
            return 'success';
        } catch(\Exception $e) {
            DB::rollback;
            \Log::info($e);
            return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
        }

    }

    //Refund
    public function refund(SoldTicket $soldTicket)
    {
        // Start transaction!
        DB::beginTransaction();
        try  {
            Transaction::create([
                'ticket_name' => $soldTicket->ticket->ticket_number,
                'destination' => $soldTicket->ticket->destination->destination_name,
                'origin' => $soldTicket->ticket->destination->routeOrigin->first()->destination_name,
                'amount_paid' => $soldTicket->amount_paid,
                'transaction_ticket_type' => $soldTicket->ticket->type,
                'status' => 'Refunded'
            ]);

            $soldTicket->delete();

            DB::commit();
            return back()->with('success', 'Ticket '.$soldTicket->ticket_number.'  has successfully been refunded');
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }

    public function multipleRefund()
    {
        $soldTicketObjArr = [];
        $this->validate(request(),[
            'refund.*' => 'exists:sold_ticket,sold_ticket_id'
        ]);

        foreach(request('refund') as $soldTicketId)
        {
            $soldTicketObj = SoldTicket::find($soldTicketId);
            if(is_null($soldTicketObj)) {
                return Response::json(['error' => 'There is a given ticket that does not exist'], 422);
            } else {

                array_push($soldTicketObjArr, $soldTicketObj);

            }
        }

        //Begin Transaction
        DB::beginTransaction();
        try {
            foreach($soldTicketObjArr as $soldTicket) {
                Transaction::create([
                    'ticket_name' => $soldTicket->ticket->ticket_number,
                    'destination' => $soldTicket->ticket->destination->destination_name,
                    'origin' => $soldTicket->ticket->destination->routeOrigin->first()->destination_name,
                    'amount_paid' => $soldTicket->amount_paid,
                    'transaction_ticket_type' => $soldTicket->ticket->type,
                    'status' => 'Refunded'
                ]);

                $soldTicket->delete();
            }
            DB::commit();

            session()->flash('success', 'The selected tickets have been refunded');
            return 'success';
        } catch (\Exception $e) {
            DB::rollback();
            return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
        }


    }

    //Lost
    public function lost(SoldTicket $soldTicket) {
        //Being Transaction
        DB::beginTransaction();
        try{
            Ledger::create([
                'description' => 'Lost/Expire Ticket',
                'amount' => $soldTicket->amount_paid,
                'type' => 'Revenue'
            ]);

            Transaction::create([
                'ticket_name' => $soldTicket->ticket->ticket_number,
                'destination' => $soldTicket->ticket->destination->destination_name,
                'origin' => $soldTicket->ticket->destination->routeOrigin->first()->destination_name,
                'amount_paid' => $soldTicket->amount_paid,
                'transaction_ticket_type' => $soldTicket->ticket->type,
                'status' => 'Lost/Expired'
            ]);
            $ticketNumber = $soldTicket->ticket->ticket_number;
            $soldTicket->delete();
            DB::commit();
            return back()->with('success','Successfully updated ticket '.$ticketNumber.' as Lost/Expired');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::info($e);
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }

    //Delete
    public function cancel(SoldTicket $soldTicket)
    {

        DB::beginTransaction();
        try {
            $ticketNumber = $soldTicket->ticket->ticket_number;
            $soldTicket->delete();
            DB::commit();

            return back()->with('success', 'Ticket '.$ticketNumber.' has been cancelled.');
        } catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
    }

    public function multipleCancel()
    {
        $soldTicketObjArr = [];

        $this->validate(request(),[
            'delete.*' => 'exists:sold_ticket,sold_ticket_id'
        ]);
        foreach(request('delete') as $soldTicketId) {
            $soldTicketObj = SoldTicket::find($soldTicketId);
            if(is_null($soldTicketObj)) {
                return Response::json(['error' => 'There is a given ticket that does not exist'],422);
            } else {
                array_push($soldTicketObjArr, $soldTicketObj);
            }
        }

        //Start Transaction
        DB::beginTransaction();
        try {
            foreach($soldTicketObjArr as $soldTicket) {
                $soldTicket->delete();
            }
            DB::commit();
            session()->flash('success', 'The selected tickets have been cancelled');
            return 'success';
        } catch(\Exception $e) {
            DB::rollback();
            return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
        }

    }


    //Selected Ticket
    public function selectTicket(Destination $destination)
    {
        $this->validate(request(),[
           'terminal' => 'required|exists:destination,destination_id'
        ]);

        if(request('ticketType') === "Regular" || request('ticketType') === "Discount") {
            $ticketType = request('ticketType');
            $ticket = $destination->tickets()->where('type',$ticketType)->whereNotIn('ticket_id', SoldTicket::all()->pluck('ticket_id'))->whereNotIn('ticket_id', SelectedTicket::all()->pluck('ticket_id'))->first();
            if(is_null($ticket)) {
                return Response::json(['error' => 'There are no more tickets left, please add another to select a ticket'], 422);
            }

            // Start transaction!
            DB::beginTransaction();
            try  {
                $selectedTicket = SelectedTicket::create([
                    'ticket_id' => $ticket->ticket_id,
                    'selected_from_terminal' => request('terminal')
                ]);

                $responseArr = ['ticketNumber' => $selectedTicket->ticket->ticket_number, 'fare' => $selectedTicket->ticket->fare,'selectedId' => $selectedTicket->selected_ticket_id];


                DB::commit();
                return response()->json($responseArr);

            } catch(\Exception $e) {
                \Log::info($e);
                DB::rollback();
                return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
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
                'terminalId'=> $selectedTicket->selected_from_terminal ,
                'ticketType'=> $selectedTicket->ticket->type,
                'fare' => $selectedTicket->ticket->fare
            ];

            $selectedTicket->delete();
            DB::commit();

            return response()->json($responseArr);
        } catch(\Exception $e) {
            DB::rollback();
            return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
        }

    }

    public function deleteLastSelectedTicket(Destination $destination)
    {
        $this->validate(request(),['terminal' => 'required|exists:destination,destination_id']);
        // Start transaction!
        DB::beginTransaction();
        try  {
            if(request('ticketType') === 'Regular' || request('ticketType') === 'Discount') {

                $ticketType = request('ticketType');
                $terminalId = request('terminal');

                $lastTicket =$destination->selectedtickets()
                    ->orderBy('selected_ticket_id','desc')
                    ->where('selected_from_terminal', $terminalId)
                    ->where('type', $ticketType)
                    ->first();
                if(is_null($lastTicket)) {
                    return Response::json(['error' => 'Unable to delete, there are no selected '.strtolower(request('ticketType')).' tickets for '.$destination->destination_name],422);
                }
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
            \Log::info($e);
            return Response::json(['error' => 'Oops! Something went wrong on the server. If the problem persists contact the administrator'],422);
        }
    }
}
