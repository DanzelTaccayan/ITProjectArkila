<?php

namespace App\Http\Controllers;

use App\Trip;
use App\Terminal;
use App\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViewVanQueueNonUserController extends Controller
{
    public function showQueue()
    {
    	$terminals = Terminal::all();
    	$farelist = Destination::all();
    	
    	return view('customermodule.non-user.fare-list.fareList', compact('terminals', 'farelist'));
    }
}
