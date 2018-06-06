<?php

namespace App\Http\Controllers;

use App\Fee;
use App\Rules\checkCurrency;
use Illuminate\Http\Request;
use App\Destination;
use DB;

class FeesController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.createFee');
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
            "addFeesDesc" => "unique:fees_and_deduction,description|regex:/^[\pL\s\-]+$/u|required|max:40",
            "addFeeAmount" => ['required',new checkCurrency,'numeric','min:1','max:5000']
        ]);

        DB::beginTransaction();
        try{
            Fee::create([
                "description" => request('addFeesDesc'),
                "amount" => request('addFeeAmount'),
            ]);

            session()->flash('message', 'Fee created successfully');

            DB::commit();
            return redirect('/home/settings');
        }
        catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Fee $fee)
    {
        
        return view('settings.editFee',compact('fee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Fee $fee)
    {
        $this->validate(request(),[
            "editFeeAmount" => ['required',new checkCurrency, 'min:1','max:5000'],
        ]);

        DB::beginTransaction();
        try{
            $fee->update([
                'amount' => request("editFeeAmount"),
            ]);

            session()->flash('message', 'Fee created successfully');
            DB::commit();
            return redirect('/home/settings');
        }
        catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(FeesAndDeduction $fee)
    // {
    //     DB::beginTransaction();
    //     try{
    //         $fee->delete();
    //         session()->flash('message', 'Fee deleted successfully');
    //         DB::commit();
    //         return back();
    //     }
    //     catch(\Exception $e) {
    //         DB::rollback();
    //         return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
    //     }

    // }

    public function editBooking(Destination $bookingfee)
    {
        return view('settings.editBookingFee', compact('bookingfee'));
    }

    public function updateBookingFee(Destination $bookingfee)
    {
        $this->validate(request(),[
           'bookingFee' => ['required', new checkCurrency]
        ]);

        DB::beginTransaction();
        try{
            $bookingfee->update([
                'booking_fee' => request('bookingFee')
            ]);

            DB::commit();
            return redirect(route('settings.index'))->with('success','Successfully updated the booking fee of '.$bookingfee->destination_name.' terminal');
        }
        catch(\Exception $e) {
            DB::rollback();
            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }
    }
}
