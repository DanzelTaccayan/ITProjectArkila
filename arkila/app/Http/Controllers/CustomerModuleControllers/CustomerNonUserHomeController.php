<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\Van;
use App\Member;
use App\Profile;
use App\Announcement;
use App\Http\Controllers\Controller;

class CustomerNonUserHomeController extends Controller
{
    public function indexNonUser()
    {
        $announcements = Announcement::where('viewer', 'Public')->orWhere('viewer', 'Customer Only')->get();
        if(auth()->user()){
            return redirect('/home', compact('announcements'));
        }else{
            return view('index', compact('announcements'));
        }

    }

    public function aboutNonUser()
    {
        $numberOfOperators = count(Member::allOperators()->get());
        $numberOfVans = count(Van::all());
        $numberOfDrivers = count(Member::allDrivers()->get());
        $profile = Profile::all();
        return view('customermodule.aboutUs',compact('numberOfOperators','numberOfVans','numberOfDrivers', 'profile'));
    }

    public function register()
    {
    	return view('customermodule.non-user.sign-up.signUp');
    }
}
