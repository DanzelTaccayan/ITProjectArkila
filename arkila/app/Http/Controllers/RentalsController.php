<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VanRental;
use Carbon\Carbon;
use App\Van;
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
        $rentals = VanRental::where('status', '!=', 'Cancelled')
        ->orWhere(function($q){
            $q->where([['status', 'Cancelled']])
            ->where('is_refundable', true);
        })->get();
        return view('rental.index', compact('rentals'));
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
        $time = date('H:i', strtotime($request->time));
        $date = Carbon::parse($request->date);
        $fullName = ucwords(strtolower($request->name));
        $destination = ucwords(strtolower($request->destination));

        $codes = VanRental::all();
        $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));

        foreach ($codes as $code)
        {
            $allCodes = $code->rental_code;

            do
            {
                $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));

            } while ($rentalCode == $allCodes);
        }

            VanRental::create([
                'rental_code' => 'RN'.$rentalCode,
                'customer_name' => $fullName,
                'van_id' => $request->plateNumber,
                'driver_id' => $request->driver,
                'departure_date' => $date,
                'departure_time' => $time,
                'destination' => $destination,
                'number_of_days' => $request->days,
                'contact_number' => $request->contactNumber,
                'is_refundable' => true,
                'rent_type' => 'Walk-in',
                'status' => 'Paid',

            ]);

            return redirect('/home/rental/')->with('success', 'Rental request from ' . $fullName . ' was created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(VanRental $rental)
    {
        $vans = Van::all();
        $drivers = Member::allDrivers()->get();

        return view('rental.show', compact('rental', 'vans', 'drivers'));
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

    public function updateStatus(VanRental $rental)
    {
        if(request('status') == 'Unpaid')
        {
            $this->validate(request(), [
                'driver' => 'required|numeric',
                'van' => 'required|numeric',
                'status' => [
                    'required',
                    Rule::in(['Unpaid'])
                ],
            ]);

            $rental->update([
                'status' => request('status'),
                'driver_id' => request('driver'),
                'van_id' => request('van'),
            ]);

            return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully accepted. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
        }
        elseif(request('status') == 'Paid')
        {
            $refundCode = bin2hex(openssl_random_pseudo_bytes(4));

            $this->validate(request(), [
                'fare' => 'required|numeric|min:1',
                'status' => [
                    'required',
                    Rule::in(['Paid'])
                ],
            ]);

            $rental->update([
                'rental_fare' => request('fare'),
                'status' => request('status'),
                'refund_code' => $refundCode,
                'is_refundable' => true,
            ]);

    
            return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully paid. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
        }
        else
        {
            $this->validate(request(), [
                'status' => [
                    'required',
                    Rule::in(['Departed'])
                ],
            ]);

            $rental->update([
                'status' => request('status'),
                'is_refundable' => false,
                'refund_code' => null,
            ]);
    
            return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully departed. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
        }
    }
}
