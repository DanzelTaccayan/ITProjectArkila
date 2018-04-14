<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Terminal;
use App\Rules\checkCurrency;
use DB;
use Illuminate\Database\QueryException;

class TerminalController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.createTerminal');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validate(request(),[
            "addTerminalName" => "unique:terminal,description|regex:/^[,\pL\s\-]+$/u|required|max:40",
            "bookingFee" => [new checkCurrency, "numeric", "required","min:1","max:5000"]
        ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            Terminal::create([
                "description" => request('addTerminalName'),
                "booking_fee" => request('bookingFee'),
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        session()->flash('message', 'Terminal created successfully');
        return redirect('/home/settings');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Terminal $terminal)
    {
        return view('settings.editTerminal', compact('terminal'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Terminal $terminal)
    {
        $this->validate(request(),[
            "editTerminalName" => 'regex:/^[,\pL\s\-]+$/u|max:40',
            "editBookingFee" => [new checkCurrency, "numeric", "required","min:1","max:5000"],
            ]);

        // Start transaction!
        DB::beginTransaction();
        try
        {
            $terminal->update([
                'description' => request('editTerminalName'),
                'booking_fee' => request('editBookingFee'),
            ]);
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        session()->flash('message', 'Terminal updated successfully');
        return redirect('/home/settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Terminal $terminal)
    {
        // Start transaction!
        DB::beginTransaction();
        try
        {
            $terminal->delete();
        }
        catch(QueryException $queryE)
        {
            DB::rollback();
            return back()->withErrors($terminal->description.' cannot be deleted. The terminal is in used');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->withErrors('There seems to be a problem. Please try again');
        }
        DB::commit();

        session()->flash('message', 'Terminal deleted successfully');
        return back();
    }
}
