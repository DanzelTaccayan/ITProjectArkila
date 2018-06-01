<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RouteRequest;
use App\Destination;
use App\Ticket;


class RoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Destination $route)
    {
        $routeId = $route->destination_id;
        $fareReg = Ticket::where('type', 'Regular')->groupBy('destination_id')->get();
        $fareDis = Ticket::where('type', 'Discount')->groupBy('destination_id')->get();
        $terminals = Destination::allTerminal()->get();
        $mainTerminal = Destination::where('is_main_terminal', 1)->get()->first();
        return view('route.index', compact('terminals', 'mainTerminal', 'fareReg', 'fareDis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createRoute()
    {
        $terminals = Destination::allTerminal()->get();
        $mainTerminal = Destination::where('is_main_terminal', 1)->get()->first();
        $type = 'Route';
        return view('route.create', compact('terminals', 'type', 'mainTerminal'));
    }

    public function createTerminal()
    {
        $terminals = Destination::allTerminal()->get();
        $mainTerminal = Destination::where('is_main_terminal', 1)->get()->first();
        $type = 'Terminal';
        return view('route.create', compact('terminals', 'type', 'mainTerminal'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RouteRequest $request)
    {
        $name = ucwords(strtolower($request->addTerminal));
        $terminals = Destination::allTerminal()->get();
        $main = Destination::where('is_main_terminal', '1')->first();
        $message = null;
        $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        $disTicketCount = 0;
        $counter = 0;

        if ($request->type == 'Terminal')
        {    
            $terminal = Destination::create([
                'destination_name' => $name,
                'booking_fee' => $request->bookingFee,
                'short_trip_fare' => $request->sTripFare,
                'short_trip_fare_discount' => $request->sdTripFare,
                'is_terminal' => true,
                'is_main_terminal' => false,
                'number_of_tickets' => $request->numticket,
            ]);

            for($c=1; $c <= $request->numticketDis; $c++)
            {
                if($disTicketCount >= 26)
                {
                    $disTicketCount = 0;
                    $counter++;
                }
    
                if($c <= 26)
                {
                    $ticketNumber = $name.'-'.$discountedTickets[$disTicketCount];
                }
                else
                {
                    $ticketNumber = $name.'-'.$discountedTickets[$disTicketCount].$counter;                
                }
    
                $disTicketCount++;
                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'destination_id' => $terminal->destination_id,
                    'fare' => $request->discountedFare,
                    'type' => 'Discount'
                ]);
            }
    
            for($i=1; $i <= $request->numticket; $i++ )
            {
                $ticketName = $name.'-'.$i;
                Ticket::create([
                    'ticket_number' => $ticketName,
                    'destination_id' => $terminal->destination_id,
                    'fare' => $request->regularFare,
                    'type' => 'Regular'
                ]);
            }

            $terminal->routeOrigin()
            ->attach($main->destination_id, ['terminal_destination' => $terminal->destination_id]);

            return redirect('/home/route#terminal'.$terminal->destination_id)->with('success', 'The terminal '. $name .' has been successfully created');

        }
        else 
        {
            $route = Destination::create([
                'destination_name' => $name,
                'is_terminal' => false,
                'is_main_terminal' => false,
                'number_of_tickets' => $request->numticket,
            ]);

            // foreach($discountedTickets as $discountedTicket)
            // {
            //     $ticketNumber = $name.'-'.$discountedTicket;
            //     Ticket::create([
            //         'ticket_number' => $ticketNumber,
            //         'destination_id' => $route->destination_id,
            //         'is_sold' => false,
            //         'fare' => $request->discountedFare,
            //         'type' => 'Discount'
            //     ]);
            // }

            for($c=1; $c <= $request->numticketDis; $c++)
            {
                if($disTicketCount >= 26)
                {
                    $disTicketCount = 0;
                    $counter++;
                }
    
                if($c <= 26)
                {
                    $ticketNumber = $name.'-'.$discountedTickets[$disTicketCount];
                }
                else
                {
                    $ticketNumber = $name.'-'.$discountedTickets[$disTicketCount].$counter;                
                }
    
                $disTicketCount++;
                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'destination_id' => $route->destination_id,
                    'fare' => $request->discountedFare,
                    'type' => 'Discount'
                ]);
            }


            for($i=1; $i <= $request->numticket; $i++ )
            {
                $ticketName = $name.'-'.$i;
                Ticket::create([
                    'ticket_number' => $ticketName,
                    'destination_id' => $route->destination_id,
                    'fare' => $request->regularFare,
                    'type' => 'Regular'
                ]);
            }
            
            foreach ($terminals as $count => $terminal) {
                if (isset($request->dest[$count])) {
                    $route->routeOrigin()
                    ->attach($main->destination_id, ['terminal_destination' => $request->dest[$count]]);
                } 
            }   
            
            return redirect('/home/route#terminal'.$route->routeDestination()->first()->destination_id)->with('success', 'The route '. $name .' has been successfully created');

        }
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
    public function edit(Destination $route)
    {
        $terminals = Destination::allTerminal()->get();
        $mainTerminal = Destination::where('is_main_terminal', 1)->get()->first();
        $routeId = $route->destination_id;
        $fareReg = Ticket::where([
            ['type', 'Regular'],
            ['destination_id', $routeId],
            ])->first();
        $fareDis = Ticket::where([
            ['type', 'Discount'],
            ['destination_id', $routeId],
            ])->first();
        return view('route.edit', compact('route', 'fareReg', 'fareDis', 'terminals', 'mainTerminal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RouteRequest $request, $route)
    {
        $ticketRegular = Ticket::where([['type', 'Regular'],['destination_id', $route]])->get();
        $ticketDiscounted = Ticket::where([['type', 'Discount'],['destination_id', $route]])->get();
        $routeAll = Destination::find($route);
        $terminals = Destination::allTerminal()->get();
        $main = Destination::where('is_main_terminal', '1')->first();
        $message = null;
        $regularTicket = Ticket::where([
            ['destination_id', $route],
            ['type', 'Regular']
            ])->get();
            // dd($regularTicket->count());
        $discountedTicket = Ticket::where([
            ['destination_id', $route],
            ['type', 'Discount']
            ])->get();

        if($request->type == 'Terminal')
        {
            $routeAll->update([
                'booking_fee' => $request->bookingFee,
                'short_trip_fare' => $request->sTripFare,
                'short_trip_fare_discount' => $request->sdTripFare,
            ]);

            $message = $routeAll->destination_name .' has been successfully updated.';
        }
        else
        {

            $routeAll->routeOrigin()->detach($main->destination_id);

            foreach ($terminals as $count => $terminal) {
                if (isset($request->dest[$count])) {
                    $routeAll->routeOrigin()
                    ->attach($main->destination_id, ['terminal_destination' => $request->dest[$count]]);
                } 
            }   
            
            $message = $routeAll->destination_name .' has been successfully updated.';
        }

        if($request->regularFare !== $ticketRegular->first()->fare)
        {
            foreach ($ticketRegular as $ticket) {
                $ticket->update([
                    'fare' => $request->regularFare,
                ]);
            }                
        }
        
        if($request->discountedFare !== $ticketDiscounted->first()->fare)
        {
            foreach ($ticketDiscounted as $ticket) {
                $ticket->update([
                    'fare' => $request->discountedFare,
                ]);
            }                                
        }
        return redirect('/home/route#terminal' .$routeAll->routeDestination()->first()->destination_id)->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Destination $route)
    {
        $main = Destination::where('is_main_terminal', '1')->first();
        $terminals = Destination::allTerminal()->get();
        $isTerminal = $route->is_terminal;
        $terminal = $route->routeDestination()->first()->destination_id;
        $message = null;

        if($route->vanQueue->count() == 0)
        {
            if ($route->is_terminal == true)
            {
                foreach($route->routeFromDestination as $routes)
                {
                    $routes->routeOrigin()->detach($main->destination_id);
                    $routes->delete();
                }
                $message = 'The terminal '. $route->destination_name .' has been successfully deleted!';
            }
            else
            {
                $route->routeOrigin()->detach($main->destination_id);
                $route->delete();
                $message = 'The route '. $route->destination_name .' has been successfully deleted!';

            }
            if($isTerminal == true)
            {
                return redirect('/home/route#terminal' .$terminals->first()->destination_id)->with('success', $message);
            }
            else
            {
                return redirect('/home/route#terminal' .$terminal)->with('success', $message);
            }  
        }
        else
        {
            return back()->withErrors('Unable to delete, there are still vans on queue in '. $route->destination_name .' Terminal.');
        }

    }
}
