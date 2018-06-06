<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Destination;

class ViewFareListController extends Controller
{
    public function fareList()
	{
		$destinations = Destination::allRoute()->orderBy('destination_name')->get();
		return view('customermodule.fareList', compact('destinations'));
	}

}
