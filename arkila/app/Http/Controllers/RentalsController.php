<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VanRental;
use Carbon\Carbon;
use App\BookingRules;
use App\Destination;
use App\Van;
use App\Ledger;
use App\User;
use App\Member;
use App\Rules\checkTime;
use App\Http\Requests\RentalRequest;
use Illuminate\Validation\Rule;
use DB;

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
        $rentals = VanRental::where([['status', '!=', 'Cancelled'],['status', '!=', 'Refunded'], ['status', '!=', 'Expired'], ['status', '!=', 'No Van Available'], ['status', '!=', 'Departed']])
        ->orWhere(function($q){
            $q->where([['status', 'Cancelled']])
            ->where('is_refundable', true);
        })->get();
        $rule = $this->rentalRules();
        return view('rental.index', compact('rentals', 'rule'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rule = $this->rentalRules();
        if($rule) {
	        $vans = Van::all();
	        $drivers = Member::allDrivers()->get();
	        $destinations = Destination::allRoute()->get();
	        return view('rental.create', compact('vans', 'drivers', 'destinations', 'rule'));        	
        } else {
        	return redirect(route('rental.index'));
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RentalRequest $request)
    {
        $rule = $this->rentalRules();

        if($rule) {
	        $time = date('H:i', strtotime($request->time));
	        $date = Carbon::parse($request->date);
	        $fullName = ucwords(strtolower($request->name));
	        if($request->destination == 'other') {
	            $destination = ucwords(strtolower($request->otherDestination));
	        }
	        else {
	            $destination = ucwords(strtolower($request->destination));            
	        }

	        $codes = VanRental::all();
	        $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));

	        foreach ($codes as $code) {
	            $allCodes = $code->rental_code;

	            do {
	                $rentalCode = bin2hex(openssl_random_pseudo_bytes(5));

	            } while ($rentalCode == $allCodes);
	        }
            // Start transaction!
            DB::beginTransaction();
            try  {
                VanRental::create([
                    'rental_code' => 'RN'.$rentalCode,
                    'customer_name' => $fullName,
                    'van_id' => $request->plateNumber,
                    'driver_id' => $request->driver,
                    'departure_date' => $date,
                    'departure_time' => $time,
                    'destination' => $destination,
                    'number_of_days' => $request->days,
                    'rental_fare' => $request->totalFare,
                    'contact_number' => $request->contactNumber,
                    'is_refundable' => true,
                    'rent_type' => 'Walk-in',
                    'status' => 'Paid',

                ]);

                if($request->destination == 'other') {
                    Ledger::create([
                        'description' => 'Rental Fee',
                        'amount' => $rule->fee,
                        'type' => 'Revenue',
                    ]);
                }

                DB::commit();
                return redirect('/home/rental/')->with('success', 'Rental request from ' . $fullName . ' was created successfully');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);

                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }

        } else {
         		return redirect(route('rental.index'));
        }

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
        // $drivers = User::allDrivers()->whereNotIn('id', VanRental::select('driver_id')->where('status', '!=', 'Departed'))->get();
        $rules = $this->rentalRules();
        $destination = Destination::where('destination_name', 'like', '%' . $rental->destination . '%')->get()->first();

        return view('rental.show', compact('rental', 'vans', 'drivers', 'rules', 'destination'));
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

        // Start transaction!
        DB::beginTransaction();
        try  {
            $rental->update([
                'status' => request('click'),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Rental requested by ' . $rental->full_name . ' was marked as '. request('click'));
        } catch(\Exception $e) {
            DB::rollback();
            \Log::info($e);

            return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy(VanRental $rental)
    // {
    //     $rental->delete();
    //     return back()->with('message', 'Successfully Deleted');

    // }

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

            // Start transaction!
            DB::beginTransaction();
            try  {
                $rental->update([
                    'status' => request('status'),
                    'driver_id' => request('driver'),
                    'van_id' => request('van'),
                ]);

                DB::commit();
                return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully accepted. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);

                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }

        } elseif(request('status') == 'Decline') {
            // Start transaction!
            DB::beginTransaction();
            try  {
                $rental->update([
                    'status' => 'No Van Available',
                ]);

                DB::commit();
                return redirect(route('rental.index'))->with('success', 'Rental has been declined.');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);

                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }
        } elseif(request('status') == 'Paid') {
            $refundCode = bin2hex(openssl_random_pseudo_bytes(4));

            $this->validate(request(), [
                'fare' => 'required|numeric|min:1',
                'status' => [
                    'required',
                    Rule::in(['Paid'])
                ],
            ]);

            // Start transaction!
            DB::beginTransaction();
            try  {
                $totalPayment = request('fare');

                $destination = Destination::allRoute()->where('destination_name', $rental->destination)->count();
                if($destination == 0) {
                    $rule = $this->rentalRules();
                    // $totalPayment = request('fare') + $rule->fee;

                    Ledger::create([
                        'description' => 'Rental Fee',
                        'amount' => $rule->fee,
                        'type' => 'Revenue',
                    ]);
                }
                // } else {
                // }

                $rental->update([
                    'rental_fare' => $totalPayment,
                    'status' => request('status'),
                    'refund_code' => $refundCode,
                    'is_refundable' => true,
                    'date_paid' => Carbon::now(),
                ]);

                DB::commit();
                return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully paid. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);
                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }

        } elseif(request('status') == 'Departed') {
            $this->validate(request(), [
                'status' => [
                    'required',
                    Rule::in(['Departed'])
                ],
            ]);

            // Start transaction!
            DB::beginTransaction();
            try  {
                $rental->update([
                    'status' => request('status'),
                    'is_refundable' => false,
                    'refund_code' => null,
                ]);

                DB::commit();
                return redirect(route('rental.show', $rental->rent_id))->with('success', 'Rental has been successfully departed. [Van:'.$rental->van->plate_number.' Driver:'. $rental->driver->full_name .' ]');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);

                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }

        } else {
            $this->validate(request(), [
                'refund' => 'required|min:0|max:20',
                'status' => [
                    'required',
                    Rule::in(['Refunded'])
                ],
            ]);
            
            if($rental->is_refundable == true) {
                if(request('refund') == $rental->refund_code) {
                    // Start transaction!
                    DB::beginTransaction();
                    try  {
                        $rental->update([
                            'status' => request('status'),
                            'is_refundable' => false,
                            'refund_code' => null,
                        ]);
                        DB::commit();
                        return redirect(route('rental.index'))->with('success', 'Rental has been successfully refunded.');
                    } catch(\Exception $e) {
                        DB::rollback();
                        \Log::info($e);

                        return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
                    }
                } else {
                    return back()->withErrors('Refund code does not match, please try again.');
                }
            } else {
                return back()->withErrors('Rental code '.$rental->rental_code.' cannot be refunded.');
            }
        }
    }

    public function changeDepartureDateTime(Request $request, VanRental $rental)
    {
        if($rental->status == 'Paid')
        {
            // can change the date of departure 2 days before the departure date.
            $date = $rental->departure_date->subDays(2)->formatLocalized('%d %B %Y');
    
            $this->validate(request(), [
                'date' => 'bail|required|date_format:m/d/Y|before:'.$date,
                'time' => ['bail',new checkTime, 'required'],
            ]);

            // Start transaction!
            DB::beginTransaction();
            try  {
                $time = date('H:i:s', strtotime($request->time));
                $date = Carbon::parse($request->date);

                $rental->update([
                    'departure_date' => $date,
                    'departure_time' => $time,
                ]);
                DB::commit();
                return back()->with('success', 'You have successfully modified your departure date and time.');
            } catch(\Exception $e) {
                DB::rollback();
                \Log::info($e);

                return back()->withErrors('Oops! Something went wrong on the server. If the problem persists contact the administrator');
            }
        } else {
            return back()->withErrors('Cannot modify departure date and time');
        }
    }

    public function rentalRules() 
    {
        return BookingRules::where('description', 'Rental')->get()->first();
    }
}
