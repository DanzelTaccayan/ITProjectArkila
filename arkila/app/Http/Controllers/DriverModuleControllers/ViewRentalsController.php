<?php

namespace App\Http\Controllers\DriverModuleControllers;

use App\Rental;
use App\Van;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ViewRentalsController extends Controller
{
    public function viewRentals()
    {
        $rentals = Rental::all();
        $vans = Van::all();
        return view('drivermodule.rentals.rental', compact('rentals', 'vans'));
    }
    
    public function updateRental(Rental $rental)
    {
        $message = null;
        $request = request('click');
        if ($rental->status == 'Accepted' && $request == 'Accepted' ) {
            return redirect()->back()->withErrors('Sorry, the rental request has been already accepted.');
        } else {
            if ($rental->status == 'Pending' && $rental->model_id == null) {
                $rental->update([
                    'model_id' => Auth::user()->model_id,
                    'driver_id' => Auth::id(),
                    'status' => request('click'),
                ]);                    
            } elseif ($rental->status == 'Pending') {
                $rental->update([
                    'driver_id' => Auth::id(),
                    'status' => request('click'),
                ]);
            } elseif ($rental->model_id == null) {
                $rental->update([
                    'model_id' => Auth::user()->model_id,
                    'status' => request('click'),
                ]);
            } else {
                $rental->update([
                    'status' => request('click'),
                ]);
            }

            $message = 'You have accepted the rental request from ' . $rental->last_name . ', ' . $rental->first_name . ' going to ' . $rental->destination;
            return redirect()->back()->with('success', $message);
        }
    }
    
}
