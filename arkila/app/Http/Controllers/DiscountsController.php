<?php

namespace App\Http\Controllers;
use App\FeesAndDeduction;
use App\Rules\checkCurrency;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('settings.createDiscount');
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
            "addDiscountDesc" => "unique:fees_and_deduction,description|regex:/^[\pL\s\-]+$/u|required|max:40",
            "addDiscountAmount" => ['required',new checkCurrency,'numeric','min:1','max:5000']
        ]);

        FeesAndDeduction::create([
            "description" => request('addDiscountDesc'),
            "amount" =>request('addDiscountAmount'),
            "type" => "Discount"
        ]);

        session()->flash('message', 'Discount created successfully');
        return redirect('/home/settings');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(FeesAndDeduction $discount)
    {
        return view('settings.editDiscount', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FeesAndDeduction $discount)
    {
        $this->validate(request(),[
            "editDiscountDesc" => "unique:fees_and_deduction,description,".$discount->fad_id."|regex:/^[\pL\s\-]+$/u|max:40",
            "editDiscountAmount" => [new checkCurrency, 'numeric','min:1','max:5000'],
        ]);

        $discount->update([
           'amount' => request('editDiscountAmount'),
        ]);

        session()->flash('message', 'Discount updated successfully');
        return redirect('/home/settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(FeesAndDeduction $discount)
    {
        $discount->delete();
        session()->flash('message', 'Discount deleted successfully');
        return back();
    }
}
