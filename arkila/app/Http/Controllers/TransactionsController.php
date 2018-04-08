<?php

namespace App\Http\Controllers;

use App\FeesAndDeduction;
use App\Ledger;
use App\Trip;
use App\Terminal;
use App\Transaction;
use App\Ticket;
use Carbon\Carbon;
use App\Member;

class TransactionsController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $terminals = Terminal::whereNotIn('terminal_id',[auth()->user()->terminal_id])->get();

        return view('transaction.index',compact('terminals'));
    }

    public function manageTickets(){
        $terminals = Terminal::whereNotIn('terminal_id',[auth()->user()->terminal_id])->get();

        return view('transaction.managetickets',compact('terminals'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {
        $this->validate(request(),[
            'terminal' => 'exists:terminal,terminal_id',
            'destination' => 'exists:destination,destination_id',
            'discount' => 'nullable|exists:fees_and_deduction,fad_id',
            'ticket.*' => 'exists:ticket,ticket_id'
        ]);

        foreach (request('ticket') as $ticketId){
            if( !(Transaction::where([['ticket_id',$ticketId],['status','Pending']])->first()) ) {
                Transaction::create([
                    'terminal_id' => request('terminal'),
                    'ticket_id' => $ticketId,
                    'destination_id' => request('destination'),
                    'fad_id' => request('discount'),
                    'trip_id' => null,
                    'status' => 'Pending'
                ]);

                $ticket = Ticket::find($ticketId);

                $ticket ->update([
                    'isAvailable' => 0
                ]);
            }
        }
        return back();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  Trip $trip
     * @return \Illuminate\Http\Response
     */
    public function update(Terminal $terminal) {
        if( $trip = $terminal->trips->where('queue_number',1)->first() ){
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);
            $totalPassengers = count(request('transactions'));


            $totalBooking = (Terminal::find(auth()->user()->terminal_id)->booking_fee) * $totalPassengers;


            $totalCommunity = (FeesAndDeduction::where('description', 'Community Fund')->first()->amount) * $totalPassengers;

            if($totalPassengers >= 10){
                $sop = 100;

                Ledger::create([
                    'description' => 'SOP',
                    'amount' => $sop,
                    'type' => 'Revenue'
                ]);

            }else{
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


            if($totalPassengers <= 10){
                if(Trip::where('terminal_id',$terminal->terminal_id)->whereNotNull('queue_number')->first() ?? null){
                    $queueNumber = Trip::where('terminal_id',$terminal->terminal_id)->orderBy('queue_number','desc')->first()->queue_number+1;

                }else{
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


            foreach(request('transactions') as $transactionId){
                $transaction = Transaction::find($transactionId);

                        $transaction->update([
                            'status' => 'Departed',
                            'trip_id' => $trip->trip_id
                        ]);

                        $transaction->ticket->update([
                           'isAvailable' => '1'
                        ]);
            }

            foreach($trips = $terminal->trips()->whereNotNull('queue_number')->get() as $trip){
                if(count($trips) > 1){
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

    public function updatePendingTransactions() {
        if(request('transactions')){
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);

            foreach(request('transactions') as $transactionId){
                $transaction = Transaction::find($transactionId);
                    $transaction->update([
                        'status' => 'OnBoard',
                        'trip_id' => null
                    ]);
            }

            return 'success';
        }else{
            return 'error no transaction given';
        }

    }


    public function updateOnBoardTransactions() {
        if(request('transactions')){
            $this->validate(request(),[
                'transactions.*' => 'required|exists:transaction,transaction_id'
            ]);

            foreach(request('transactions') as $transactionId){
                $transaction = Transaction::find($transactionId);
                $transaction->update([
                    'status' => 'Pending',
                    'trip_id' => null
                ]);
            }

            return 'success';
        }else{
            return 'error no transaction given';
        }

    }

    public function changeDestination(Transaction $transaction) {
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
    public function destroy(Transaction $transaction) {
        $this->validate(request(),[
            'delete' => 'exists|ticket,ticket_id'
        ]);

        $transaction->update([
            'status' => 'Deleted'
        ]);

        //put transaction into ledger
        if($transaction->feesAndDeduction){
                $discount = $transaction->feesAndDeduction->amount;
        }else{
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

    public function multipleDelete(){
        $transactionObjArr = [];
        $this->validate(request(),[
            'delete.*' => 'exists:transaction,transaction_id'
        ]);


        foreach(request('delete') as $transactionId){
            array_push($transactionObjArr, Transaction::find($transactionId));
        }

        foreach($transactionObjArr as $transaction){

            $transaction->update([
                'status' => 'Deleted'
            ]);

            //put transaction into ledger
            if($transaction->feesAndDeduction){
                $discount = $transaction->feesAndDeduction->amount;
            }else{
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

    public function listDestinations(Terminal $terminal) {
        $destinationArr = [];

        foreach($terminal->destinations as $destination){
            array_push($destinationArr,[
                'id'=> $destination->destination_id,
                'description' => $destination->description
            ]);
        }

        return response()->json($destinationArr);
    }

    public function listDiscounts() {
        $discountArr = [];
        $discounts = FeesAndDeduction::discounts()->get();

        foreach ($discounts as $discount){
            array_push($discountArr,[
                'id' => $discount->fad_id,
                'description' => $discount->description
            ]);
        }

        return response()->json($discountArr);
    }

    public function listTickets(Terminal $terminal) {
        $ticketsArr = [];
        $tickets = $terminal->tickets()->where('isAvailable', 1)->orderBy('ticket_id','asc')->get();
        $seatingCapacity = ($terminal->trips->where('queue_number',1)->first()->van->seating_capacity)+2;

        for($i=0; $i < $seatingCapacity ; $i++){
            if(count($tickets) > $i){
                array_push($ticketsArr,[
                    'id' => $tickets[$i]->ticket_id,
                    'ticket_number' => $tickets[$i]->ticket_number
                ]);
            }else{
                continue;
            }
        }

        return response()->json($ticketsArr);
    }

    public function manage() {
        return view('transaction.managetickets');
    }
    public function listSourceDrivers(){
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

    public function changeDriver(Trip $trip){
        $this->validate(request(),[
           'value' => 'exists:member,member_id'
        ]);

        $trip->update([
           'driver_id' => request('value')
        ]);

        return 'success';
    }

    public function getTicketManagementPartial(Terminal $terminal) {
        return view('transaction.managetickets',compact('terminal'));
    }

    public function refund(Transaction $transaction){
        $transaction->update([
            'status' => 'Refunded'
        ]);

        $transaction->ticket->update([
            'isAvailable' => 1
        ]);

        return 'success';
    }
}
