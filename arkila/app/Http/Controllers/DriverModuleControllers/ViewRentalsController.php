<?php

namespace App\Http\Controllers\DriverModuleControllers;

use App\Rental;
use App\Van;
use App\User;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ViewRentalsController extends Controller
{
    public function viewRentals()
    {
        $user = User::find(Auth::id());
        $model_id = $user->member->van->first()->model_id ?? null;
        $rentals = Rental::where('model_id', $model_id)->get();
        $vans = Van::all();
        return view('drivermodule.rentals.rental', compact('rentals', 'vans', 'model_id'));
    }

    public function updateRental(Rental $rental)
    {
      $this->validate(request(),[
        "click" => [
          'required',
          Rule::in(['Accepted', 'Declined', 'Departed', 'Pending', 'Cancelled', 'Expired'])
        ],
      ]);


        $message = null;
        $request = request('click');
        $plate_number = User::find(Auth::id());
        if ($rental->status == 'Accepted' && $request == 'Accepted' ) {
            return redirect()->back()->withErrors('Sorry, the rental request has been already accepted.');
        } else {
            if ($rental->status == 'Pending' && $rental->model_id == null) {
                $rental->update([
                    'plate_number' => $plate_number->member->van->first()->plate_number,
                    'model_id' => Auth::user()->model_id,
                    'driver_id' => Auth::id(),
                    'status' => request('click'),
                ]);
                $message = 'You have accepted the rental request from ' . $rental->last_name . ', ' . $rental->first_name . ' going to ' . $rental->destination;
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
            } elseif($rental->status == 'Pending' && ($rental->model_id !== null && $rental->plate_number !== null)) {
              $rental->update([
                  'status' => request('click'),
              ]);
            } else {
                $rental->update([
                    'status' => request('click'),
                ]);
            }


            return redirect()->back()->with('success', $message);
        }
    }

}
