<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VanRental;
use Carbon\Carbon;
use App\Van;
use App\VanModel;
use App\Member;
use App\Http\Requests\RentalRequest;
use Illuminate\Validation\Rule;

class RentalsController extends Controller
{
    public function __construct()
    {
      $this->middleware('walkin-rental', ['only' => ['create', 'store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $rentals = VanRental::all();
        $vans = Van::all();
        return view('rental.index', compact('vans', 'rentals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vans = Van::all();
        $drivers = Member::allDrivers()->get();
        return view('rental.create', compact('vans', 'drivers'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentalRequest $request)
    {
        $fullName = ucwords(strtolower($request->name));

            Rental::create([
                'customer_name' => $fullName,
                'plate_number' => $request->plateNumber,
                'driver_id' => $request->driver,
                'departure_date' => $request->date,
                'departure_time' => $request->time,
                'destination' => $request->destination,
                'number_of_days' => $request->days,
                'contact_number' => $request->contactNumber,
                'rent_type' => 'Walk-in',
                'status' => 'Paid',

            ]);

            return redirect('/home/rental/')->with('success', 'Rental request from ' . $fullName . ' was created successfully');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VanRental $rental)
    {
      $this->validate(request(),[
        "click" => [
          'required',
          Rule::in(['Paid', 'Departed', 'Cancelled', 'Refunded'])
        ],
      ]);
        $rental->update([
            'status' => request('click'),
        ]);
        return redirect()->back()->with('success', 'Rental requested by ' . $rental->full_name . ' was marked as '. request('click'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(VanRental $rental)
    {
        $rental->delete();
        return back()->with('message', 'Successfully Deleted');

    }
}
