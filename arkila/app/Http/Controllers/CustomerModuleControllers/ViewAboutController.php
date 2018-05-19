<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Http\Controllers\Controller;
use App\Member;
use App\Van;
use App\Profile;

class ViewAboutController extends Controller
{
    public function viewAbout()
    {
        $numberOfOperators = count(Member::allOperators()->get());
        $numberOfVans = count(Van::all());
        $numberOfDrivers = count(Member::allDrivers()->get());
        $profile = Profile::all();
    	return view('customermodule.aboutUs',compact('numberOfOperators','numberOfVans','numberOfDrivers', 'profile'));
    }
}
