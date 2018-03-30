<?php

namespace App\Http\Controllers;

use App\FeesAndDeduction;
use App\Rules\checkCurrency;
use Illuminate\Http\Request;

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

        FeesAndDeduction::create([
            "description" => request('addFeesDesc'),
            "amount" => request('addFeeAmount'),
            "type" => "Fee"
        ]);

        session()->flash('message', 'Fee created successfully');
        return redirect('/home/settings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FeesAndDeduction $fee)
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
    public function update(FeesAndDeduction $fee)
    {
        $this->validate(request(),[
            "editFeeAmount" => ['required',new checkCurrency, 'numeric', 'min:1','max:5000'],
        ]);

        $fee->update([
            'amount' => request("editFeeAmount"),
        ]);
        
        session()->flash('message', 'Fee created successfully');
        return redirect('/home/settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeesAndDeduction $fee)
    {
        $fee->delete();
        session()->flash('message', 'Fee deleted successfully');
        return back();
    }
}
