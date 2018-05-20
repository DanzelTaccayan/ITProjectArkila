<?php

namespace App\Http\Controllers\DriverModuleControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Destination;
use App\Announcement;
use App\Terminal;
use App\Trip;

class DriverHomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth::driver');
    // }

    public function index()
    {
      $announcements = Announcement::latest()->where('viewer', '=', 'Public')->orWhere('viewer', '=', 'Driver Only')->get();
      if(auth()->user()->member->van->count() == 1)
      {
        $queueNumber = auth()->user()->member->van->first()->vanQueue->first()->queue_number ?? null;
      }
      else
      {
        $queueNumber = null;
      }
      
      return view('drivermodule.index', compact('announcements', 'queueNumber'));
    }
}
