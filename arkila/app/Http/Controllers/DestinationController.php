<?php

namespace App\Http\Controllers;

use App\Terminal;
use App\Destination;
use App\Rules\checkCurrency;
use App\Rules\checkTerminal;
use DB;
use Validator;
use Illuminate\Database\QueryException;
use Response;

class DestinationController extends Controller
{

    public function create()
    {
        $terminals = Terminal::whereNotIn('terminal_id', [auth()->user()->terminal_id])->get();
        return view('settings.createDestination', compact('terminals'));
    }

    public function store()
    {
        $this->validate(request(),[
            "addDestination" => "unique:destination,description|regex:/^[,\pL\s\-]+$/u|required|max:40",
            "addDestinationTerminal" => ['required', new checkTerminal, 'max:40'],
            "addDestinationFare" => ['required', new checkCurrency, 'numeric','min:1','max:5000']
        ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            Destination::create([
                "terminal_id" => request('addDestinationTerminal'),
                "description" => request('addDestination'),
                "amount" => request('addDestinationFare')
            ]);
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
