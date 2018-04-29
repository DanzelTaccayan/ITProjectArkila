<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Destination;
use App\Feature;
use App\Terminal;
use App\User;
use App\Van;
use App\Member;
use App\Reservation;
use App\VanRental;
use App\Fee;


class HomeController extends Controller
{
   // /**
   //  * Create a new controller instance.
   //  *
   //  * @return void
   //  */
   // public function __construct()
   // {
   //     $this->middleware('auth:admin');
   // }

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
        $terminalsFee = Destination::all();
        $tickets = Ticket::all();
        $features = Feature::all();

        return view('settings.index', compact('fees','tickets','features','terminalsFee'));
    }

    public function usermanagement()
    {
        $userAdmins = User::join('terminal', 'users.terminal_id', '=', 'terminal.terminal_id')->orderBy('users.created_at', 'desc')->admin()->select('users.id as userid','users.first_name', 'users.middle_name', 'users.last_name', 'users.username', 'terminal.terminal_id', 'terminal.description')->get();
        $userDrivers = User::driver()->where('users.terminal_id','=', null)->get();
        $userCustomers = User::customer()->where('users.terminal_id','=', null)->get();
        return view('usermanagement.index', compact('userAdmins', 'userDrivers', 'userCustomers'));
    }

    public function archive() {
        $operators = Member::allOperators()->where('status','Inactive')->get();

        return view('archive.index', compact('operators'));

    }

    public function showProfile(Member $archive)
    {

        return view('archive.operatorArchive',compact('archive'));
    }

    public function vanDriver(Member $operator) {

        return view('archive.vanDriver', compact('operator'));

    }
    public function changeFeatures(Feature $feature) {
        if($feature->Status === 'enable'){
          $feature->Status = 'disable';
          session()->flash('success', $feature->description . 'has been successfully disabled');
          //$message = ['success' => $feature->description . 'has been successfully disabled'];
        }elseif($feature->Status === 'disable'){
          $feature->Status = 'enable';
          //$message = ['success' => $feature->description . 'has been successfully enabled'];
          session()->flash('success', $feature->description . 'has been successfully enabled');
        }

        $feature->save();
        return response()->json(true);

    }

}
