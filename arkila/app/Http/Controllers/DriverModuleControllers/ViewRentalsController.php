<?php

namespace App\Http\Controllers\DriverModuleControllers;

use App\VanRental;
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
        // $user = User::find(Auth::id());
        // $model_id = $user->member->van->first()->model_id ?? null;
        // $rentals = VanRental::where('model_id', $model_id)->orWhere('model_id', null)->get();
        // $vans = Van::all();
        $rentals = VanRental::where('status', 'Pending')->get();
        $acceptedRental = VanRental::where([['driver_id', auth()->user()->id], ['status', '!=', 'DEPARTED']])->get()->first();
        $rentalHistory = VanRental::where([['driver_id', auth()->user()->id], ['status', 'DEPARTED']])->get();
        return view('drivermodule.rentals.rental', compact('rentals', 'acceptedRental', 'rentalHistory'));
    }
}
