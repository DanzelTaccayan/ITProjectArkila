<?php

namespace App\Http\Controllers;

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
    public function update(Destination $ticket_management)
    {
        $soldTickets = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Regular'],
            ['is_sold', true],
            ])->count();
        $regularTicket = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Regular'],
            ])->get();
        $fare = $regularTicket->first()->fare;
        $name = $ticket_management->destination_name;
        
        if ($soldTickets == 0)
        {
            $ticket_management->update([
            'number_of_tickets' => request('numberOfTicket'),
            ]);

            for($i=1; $i <= request('numberOfTicket'); $i++ )
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

            foreach($regularTicket as $ticket)
            {               
                $ticket->delete();
            }

            return $ticket_management->number_of_tickets;
        }
        else
        {
            session()->flash('error', 'Cannot edit the ticket number, all tickets must be return first.');
            return 'Cannot edit the ticket number, all tickets must be return first.';
        }
    }

    public function updateDiscount(Destination $ticket_management)
    {
        $soldTickets = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Discount'],
            ['is_sold', true],
            ])->count();
        $discountTicket = Ticket::where([
            ['destination_id', $ticket_management->destination_id],
            ['type', 'Discount'],
            ])->get();
        if ($discountTicket->count() > 0)
        {
            $fare = $discountTicket->first()->fare;
        }
        $name = $ticket_management->destination_name;
        $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $countLetters = count($discountedTickets);
        $requestNumTicket = request('numberOfTicket');
        if ($soldTickets == 0)
        {
            if($requestNumTicket == 0)
            {
                foreach($discountTicket as $ticket)
                {               
                    $ticket->delete();
                }
      
            }
            elseif($requestNumTicket == 26 && $discountTicket->count() == 0)
            {
                foreach($discountedTickets as $discountedTicket)
                {
                    $ticketNumber = $name.'-'.$discountedTicket;
                    Ticket::create([
                        'ticket_number' => $ticketNumber,
                        'destination_id' => $ticket_management->destination_id,
                        'is_sold' => false,
                        'fare' => '100',
                        'type' => 'Discount'
                    ]);
                }
          
            }
            elseif ($requestNumTicket > 26)
            {
                $counter = 1;
                $c = 0;
                $toBeAdded = $requestNumTicket - $discountTicket->count();

                for($i=1; $i <= $toBeAdded; $i++ )
                {
                    if($i % 27 == 0)
                    {
                        $counter++;
                    }
                    
                    if($c > 26)
                    {
                        $c = 0;
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

            // return $ticket_management->number_of_tickets;
        }
        else
        {
            session()->flash('error', 'Cannot edit the ticket number, all tickets must be return first.');
            return 'Cannot edit the ticket number, all tickets must be return first.';
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
