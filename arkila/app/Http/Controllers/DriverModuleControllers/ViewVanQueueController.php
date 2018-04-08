<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Terminal;
use App\Destination;
use App\Trip;
use App\User;
use App\Member;
class ViewVanQueueController extends Controller
{
    public function showVanQueue()
    {
      $destinations = Destination::all();
      $terminals = Terminal::all();
      $trips = Trip::join('member', 'trip.driver_id', '=', 'member.member_id')
                    ->join('terminal', 'trip.terminal_id', '=', 'terminal.terminal_id')
                    ->join('van', 'trip.plate_number', '=', 'van.plate_number')
                    ->where('member.role', '=', 'Driver')
                    ->where('trip.status', '<>', 'Departed')
                    ->orderBy('trip.created_at','asc')
                    ->select('trip.trip_id as trip_id', 'trip.queue_number as queueId', 'trip.plate_number as plate_number', 'trip.remarks as remarks', 'terminal.description as terminaldesc')->get();
      // return response(view('drivermodule.index', compact('trips')), 200, ['Content-Type' => 'application/json']);
      $superAdmin = User::where('user_type', 'Super-Admin')->first();
      $superAdminTerminal = $superAdmin->terminal->terminal_id;
      //dd($terminals);
      // foreach($terminals as $key => $value){
      //   //echo $superAdminTerminal . " " . "<br/>";
      //   if($value->terminal_id == $superAdminTerminal){
      //       continue;
      //   }

      //   if($key == 1){
      //     echo $key . " " . "<br/>";
      //   } 
        
      // }
      return view('drivermodule.indexVanQueue', compact('destinations', 'terminals', 'trips', 'superAdminTerminal'));
    }
}
