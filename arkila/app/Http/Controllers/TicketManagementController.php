<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Destination;
use Carbon\Carbon;
use App\Ticket;
use App\TicketRule;
use App\SoldTicket;
use DB;

class TicketManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticketRule = TicketRule::get()->first();
        $routes = Destination::all()->where('is_main_terminal', false);
        return view('ticketmanagement.index', compact('routes', 'ticketRule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Destination $ticket_management, Request $request)
    {
        // $soldTickets = Ticket::where([
        //     ['destination_id', $ticket_management->destination_id],
        //     ['type', 'Regular'],
        //     ['status', '!=', null],
        //     ])->count();

        $numberOfSoldTickets = 0;
        $soldTickets = SoldTicket::all();
        if($soldTickets->count() > 0) {
            foreach($soldTickets as $soldTicket) {
                if ($soldTicket->ticket->destination_id == $ticket_management->destination_id && $soldTicket->ticket->type == 'Regular') {
                    $numberOfSoldTickets++;
                }
            }
        }
        $regularTicket = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Regular'],
            ])->orderBy('ticket_id', 'desc')->get();
        $fare = $regularTicket->first()->fare;
        $name = $ticket_management->destination_name;
        $ticketOrig = $ticket_management->number_of_tickets;
        $ticketRequest = $request->numberOfTicket;

        $validate = Validator::make($request->all(), [
            "numberOfTicket" => "required|min:1|numeric",
        ]);

        if($validate->fails()) {
            return response()->json(["error" => "Please make sure that your input is valid, you can only enter numeric values greater than zero for the number of regular tickets."]);
        }
        else {
            list($name, $lastNumberOfTicket) = explode('-', $regularTicket->first()->ticket_number);
            $startCount = $lastNumberOfTicket + 1;
            
            if ($numberOfSoldTickets == 0) {

                if($ticketOrig == $ticketRequest) {
                    return response()->json(['success' => "The number of tickets of ". $ticket_management->destination_name ." remained at ". $ticketRequest, 'ticketqty' => $ticketRequest  ]);
                } else {
                    DB::beginTransaction();
                    try{
                        $ticket_management->update([
                            'number_of_tickets' => $ticketRequest,
                        ]);

                        if ($ticketOrig > $ticketRequest)
                        {
                            $numTicket = $ticketOrig - $ticketRequest;

                            foreach($regularTicket as $count => $ticket)
                            {
                                if ($count+1 <= $numTicket)
                                {
                                    $ticket->delete();
                                }
                            }
                            return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." regular ticket's number to ". $ticketRequest, 'ticketqty' => $ticketRequest  ]);
                        }
                        elseif($ticketOrig < $ticketRequest)
                        {
                            $numTicket = $ticketRequest - $ticketOrig;
                            $end = $numTicket + $ticketOrig;

                            for($i=$startCount; $i <= $end; $i++ )
                            {
                                $ticketName = $name.'-'.$i;
                                Ticket::create([
                                    'ticket_number' => $ticketName,
                                    'destination_id' => $ticket_management->destination_id,
                                    'fare' => $fare,
                                    'type' => 'Regular',
                                ]);
                            }
                        }

                        DB::commit();
                        return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." regular ticket's number to ". $ticketRequest, 'ticketqty' => $ticketRequest ]);
                    }
                    catch(\Exception $e) {
                        DB::rollback();
                        return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
                    }
        
                }
            } else {
                return response()->json(['error' => 'Cannot edit the ticket number, all tickets must be returned first.']);
            }
        }            
    }

    public function updateDiscount(Destination $ticket_management, Request $request)
    {
        $numberOfSoldTickets = 0;
        $soldTickets = SoldTicket::all();
        if($soldTickets->count() > 0) {
            foreach($soldTickets as $soldTicket) {
                if ($soldTicket->ticket->destination_id == $ticket_management->destination_id && $soldTicket->ticket->type == 'Discount') {
                    $numberOfSoldTickets++;
                }
            }
        }
        $discountTicket = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Discount'],
            ])->orderBy('ticket_id', 'desc')->get();
        $fare = $discountTicket->first()->fare;
        $name = $ticket_management->destination_name;
        $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $requestNumTicket = request('numberOfTicket');
        $lastChar = substr($discountTicket->first()->ticket_number, -1);
        $c = 0;
        $toBeAdded = $requestNumTicket - $discountTicket->count();
        
        $validate = Validator::make($request->all(), [
            "numberOfTicket" => "required|min:1|numeric",
        ]);

        if($validate->fails() || $requestNumTicket % 26 !== 0)
        {
            return response()->json(["error" => "Please make sure that your input is valid, you can only enter numeric values divisible by 26 for the number of discounted tickets."],422);
        } else {
            if ($numberOfSoldTickets == 0) {
                DB::beginTransaction();
                try{
                    if($requestNumTicket == $discountTicket->count()) {
                        DB::rollback();
                        return response()->json(['success' => "The route ". $ticket_management->destination_name ." number of tickets remained at a number of ". $requestNumTicket." tickets.", 'ticketqty' => $requestNumTicket]);
                    }
                    elseif ($requestNumTicket < $discountTicket->count()) {
                        $numTicket = $discountTicket->count() - $requestNumTicket;

                        foreach($discountTicket as $count => $ticket) {
                            if ($count+1 <= $numTicket) {
                                $ticket->delete();
                            }
                        }
                        DB::commit();
                        return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." discounted ticket's number to ". $requestNumTicket, 'ticketqty' => $requestNumTicket ]);
                    } else {
                        if (is_numeric($lastChar)) {
                            $counter = $lastChar+1;
                        } else {
                            $counter = 1;
                        }

                        for($i=1; $i <= $toBeAdded; $i++ ) {
                            // if($i-1 % 26 == 0)
                            // {
                            //     $counter++;
                            // }

                            if($c >= 26) {
                                $c = 0;
                                $counter++;
                            }

                            $ticketName = $name.'-'.$discountedTickets[$c].$counter;
                            $c++;
                            Ticket::create([
                                'ticket_number' => $ticketName,
                                'destination_id' => $ticket_management->destination_id,
                                'fare' => $fare,
                                'type' => 'Discount',
                            ]);
                        }
                        DB::commit();
                    }
                    return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." discounted ticket's number to ". $requestNumTicket, 'ticketqty' => $requestNumTicket ]);
                }
                catch(\Exception $e) {
                    DB::rollback();
                    return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
                }

            } else {
                // session()->flash('error', 'Cannot edit the ticket number, all tickets must be return first.');
                return response()->json(['error' => 'Cannot edit the ticket number, all tickets must be returned first.']);
            } 
        }

    }

    public function ticketRule(Request $request) 
    {
        $ticketRule = TicketRule::get()->first();

        if($ticketRule) {
            $rule = $ticketRule->first();
            $this->validate($request, [
                'ticketExpiry' => 'required|numeric|min:0',
            ]);

            $rule->update([
                'usable_days' => $request->ticketExpiry,
            ]);
        } else {
            TicketRule::create([
                'usable_days' => $request->ticketExpiry,
            ]);
        }

        return back()->with('success', 'Expiration of tickets has been successfully updated.');
    }

    public function ticketExpiry()
    {
        $rule = TicketRule::get()->first();

        if($rule) {
            $usableDays = $rule->usable_days;
            $soldTickets = SoldTicket::all();
    
            foreach ($soldTickets as $soldTicket) {
                if($soldTicket->created_at->addDays($usableDays)->lt(Carbon::now())) {
                    $soldTicket->update([
                        'is_expired' => true,
                    ]);
                }
            }
        }
    }
}
