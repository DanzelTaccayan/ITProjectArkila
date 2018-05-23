<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use Auth;
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
        if(Auth::check()){
            if(Auth::user()->isSuperAdmin() && Auth::user()->isEnable()){
                return redirect('home/vanqueue');
            }else if(Auth::user()->isDriver() && Auth::user()->isEnable()){
                return redirect(route('drivermodule.index'));
            }else if(Auth::user()->isCustomer() && Auth::user()->isEnable()){
                return view('/home', compact('announcements'));
            }
        }else{
            return view('index', compact('announcements'));
        }
        // $announcements = Announcement::where('viewer', 'Public')->orWhere('viewer', 'Customer Only')->get();
        // if(auth()->user()){
        //     return view('/home', compact('announcements'));
        // }else{
        //     return view('index', compact('announcements'));
        // }

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
