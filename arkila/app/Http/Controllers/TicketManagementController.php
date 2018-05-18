<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Destination;
use App\Ticket;

class TicketManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $routes = Destination::all()->where('is_main_terminal', false);
        return view('ticketmanagement.index', compact('routes'));
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
        $soldTickets = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Regular'],
            ['is_sold', true],
            ])->count();
        $regularTicket = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Regular'],
            ])->orderBy('ticket_id', 'desc')->get();
        $fare = $regularTicket->first()->fare;
        $name = $ticket_management->destination_name;
        $ticketOrig = $ticket_management->number_of_tickets;
        $ticketRequest = $request->numberOfTicket;
        // dd($ticketRequest);
        $validate = Validator::make($request->all(), [
            "numberOfTicket" => "required|min:1",
        ]);

        if($validate->fails()){
            return response()->json(["error" => "Cannot enter zero value"]);
        }else{
            //$f = 'HI';
           
            list($name, $lastNumberOfTicket) = explode('-', $regularTicket->first()->ticket_number);
            $startCount = $lastNumberOfTicket + 1;
            
            if ($soldTickets == 0)
            {

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
                    return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." discounted ticket's number to ". $ticketRequest ]);
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
                        'is_sold' => false,
                        'fare' => $fare,
                        'type' => 'Regular',
                        ]);
                    }       
                }

                return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." discounted ticket's number to ". $ticketRequest ]);
            }
            else
            {
                return response()->json(['error' => 'Cannot edit the ticket number, all tickets must be return first.']);
            }
         }            
    }

    public function updateDiscount(Destination $ticket_management)
    {
        $soldTickets = Ticket::where([
            ['destination_id', '7'],
            ['type', 'Discount'],
            ['is_sold', true],
            ])->count();
        $discountTicket = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Discount'],
            ])->orderBy('ticket_id', 'desc')->get();
        $fare = $discountTicket->first()->fare;
        $name = $ticket_management->destination_name;
        $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $countLetters = count($discountedTickets);
        $requestNumTicket = request('numberOfTicket');
        $lastChar = substr($discountTicket->first()->ticket_number, -1);
        $c = 0;
        $toBeAdded = $requestNumTicket - $discountTicket->count();


        if ($soldTickets == 0)
        {
            if ($requestNumTicket < $discountTicket->count())
            {
                $numTicket = $discountTicket->count() - $requestNumTicket;

                foreach($discountTicket as $count => $ticket)
                {
                    if ($count+1 <= $numTicket)
                    {
                        $ticket->delete();
                    }
                }
                return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." discounted ticket's number to ". $requestNumTicket ]);
            }
            else                      
            {
                if (is_numeric($lastChar))
                {
                    $counter = $lastChar+1;
                }
                else
                {
                    $counter = 0;
                }    

                for($i=1; $i <= $toBeAdded; $i++ )
                {
                    // if($i-1 % 26 == 0)
                    // {
                    //     $counter++;
                    // }

                    if($c >= 26)
                    {
                        $c = 0;
                        $counter++;
                    }

                    $ticketName = $name.'-'.$discountedTickets[$c].$counter;
                    $c++;
                    Ticket::create([
                        'ticket_number' => $ticketName,
                        'destination_id' => $ticket_management->destination_id,
                        'is_sold' => false,
                        'fare' => $fare,
                        'type' => 'Discount',
                    ]);
                }                 
            }
            return response()->json(['success' => "Successfully updated ". $ticket_management->destination_name ." discounted ticket's number to ". $requestNumTicket ]);
        }
        else
        {
            // session()->flash('error', 'Cannot edit the ticket number, all tickets must be return first.');
            return response()->json(['error' => 'Cannot edit the ticket number, all tickets must be return first.']);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
