<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use App\User;

class UserDriversManagementController extends Controller
{
    public function __construct()
    {
      $this->middleware('user-status', ['only' => 'changeDriverStatus']);
    }

    public function show(User $driver_user)
    {

        return view('usermanagement.editDriver', compact('driver_user'));
    }

    public function update(User $driver_user)
    {
        $defaultpassword = "driver!@bantrans";
        $driver_user->password = Hash::make($defaultpassword);
        $driver_user->save();
        $driverName = $driver_user->first_name . " " . $driver_user->middle_name . " " . $driver_user->last_name;
        return redirect('/home/user-management')->with('success', 'Password reset successful for ' . $driverName . '');
    }

    public function changeDriverStatus()
    {
        $id = Input::get('id');

        // dd($id);
        $user = User::find($id);
        if($user->status == "enable"){
            $user->status = "disable";
            session()->flash('message', 'User successfully enabled!');
        }elseif($user->status == "disable"){
            $user->status = "enable";

            session()->flash('message', 'User successfully disabled!');
        }

        $user->save();
        return response()->json($user);
    }


}
