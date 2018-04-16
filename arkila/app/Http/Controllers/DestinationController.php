<?php

namespace App\Http\Controllers;

use App\Rules\checkDestinationUniqueness;
use App\Terminal;
use App\Destination;
use App\Rules\checkCurrency;
use App\Rules\checkTerminal;
use DB;
use Validator;
use Illuminate\Database\QueryException;
use Response;
use App\Ticket;

class DestinationController extends Controller
{

    public function create()
    {
        $terminals = Terminal::whereNotIn('terminal_id', [auth()->user()->terminal_id])->get();
        $destinations = Destination::all();
        return view('settings.createDestination', compact('terminals','destinations'));
    }

    public function store()
    {
        $this->validate(request(),[
            "addDestinationTerminal" => ['required', new checkTerminal, 'max:40'],
            "addDestination" => [new checkDestinationUniqueness,'regex:/^[,\pL\s\-]+$/u','required','max:40'],
            "addDestinationFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
            "numberOfTickets" => 'required|numeric|digits_between:1,200'
        ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            $discountedTickets = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];

            $destination = Destination::create([
                "terminal_id" => request('addDestinationTerminal'),
                "description" => request('addDestination'),
                "amount" => request('addDestinationFare')
            ]);

            foreach($discountedTickets as $discountedTicket)
            {
                $ticketNumber = request('addDestination').'-'.$discountedTicket;
                Ticket::create([
                    'ticket_number' => $ticketNumber,
                    'destination_id' => $destination->destination_id,
                    'isAvailable' => 1,
                    'type' => 'Discount'
                ]);
            }

            for($i =1; $i <= request('numberOfTickets'); $i++ )
            {
                $ticketName = request('addDestination').'-'.$i;
                Ticket::create([
                    'ticket_number' => $ticketName,
                    'destination_id' => $destination->destination_id,
                    'isAvailable' => 1,
                    'type' => 'Regular'
                ]);
            }
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        session()->flash('message', 'Destination created successfully');
        return redirect('/home/settings');
    }
    
    public function edit(Destination $destination)
    {
        return view('settings.editDestination', compact('destination'));
    }

    public function update(Destination $destination)
    {
        $this->validate(request(),[
            "editDestinationFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000'],
        ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            $destination->update([
                'amount' => request('editDestinationFare'),
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        session()->flash('message','Destination updated successfully');
        return redirect('/home/settings');
    }

    public function destroy(Destination $destination)
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            $destination->delete();
        }
        catch(QueryException $queryE)
        {
            DB::rollback();
            return back()->withErrors($destination->description.' cannot be deleted. The terminal is in used');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        session()->flash('message', 'Destination created successfully');
        return back();
    }
}
