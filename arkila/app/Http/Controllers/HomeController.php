<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Destination;
use App\Feature;
use App\User;
use App\Van;
use App\Member;
use App\Reservation;
use App\VanRental;
use App\Fee;


class HomeController extends Controller
{
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $numberOfOperators = count(Member::allOperators()->get());
        $numberOfVans = count(Van::all());
        $numberOfReservations =count(Reservation::all());
        $numberOfRentals = count(VanRental::all());
        return view('home', compact('numberOfOperators','numberOfVans','numberOfReservations','numberOfRentals'));
    }

    public function settings(){
        $fees = Fee::latest()->get();
        $terminals = Destination::withMainTerminal()->get();
        $tickets = Ticket::all();
        $features = Feature::all();

        return view('settings.index', compact('fees','tickets','features','terminals'));
    }

    public function usermanagement()
    {
        // $userAdmins = User::join('terminal', 'users.terminal_id', '=', 'terminal.terminal_id')->orderBy('users.created_at', 'desc')->admin()->select('users.id as userid','users.first_name', 'users.middle_name', 'users.last_name', 'users.username', 'terminal.terminal_id', 'terminal.description')->get();
        $userDrivers = User::driver()->get();
        $userCustomers = User::customer()->get();

        return view('usermanagement.index', compact('userDrivers', 'userCustomers'));
    }

    public function changeFeatures(Feature $feature) {
        if($feature->status === 'enable'){
          $feature->status = 'disable';
          session()->flash('success', $feature->description . 'has been successfully disabled');
          //$message = ['success' => $feature->description . 'has been successfully disabled'];
        }elseif($feature->status === 'disable'){
          $feature->status = 'enable';
          //$message = ['success' => $feature->description . 'has been successfully enabled'];
          session()->flash('success', $feature->description . 'has been successfully enabled');
        }

        $feature->save();
        return response()->json(true);

    }

}
