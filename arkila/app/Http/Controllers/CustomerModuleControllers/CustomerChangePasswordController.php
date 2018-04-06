<?php

namespace App\Http\Controllers\CustomerModuleControllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class CustomerChangePasswordController extends Controller
{
    public function viewChangePassword()
    {
      $customerId = Auth::id();
      return view('customermodule.user.changepassword.index', compact('customerId'));
    }

    public function checkCurrentPassword()
    {
      if(Auth::id() == request('id')){

        $checkCurrentPassword = Hash::check(request('current_password'), Auth::user()->password);
        if($checkCurrentPassword){
          return response()->json([
            'success' => $checkCurrentPassword
          ]);
        }else{
          return response()->json([
            'success' => $checkCurrentPassword
          ]);
        }
      }
      return response()->json([
        'message' => 'You do not have access to that account! '
      ]);
    }

    public function updatePassword(User $customerId)
    {
      $checkCurrentPassword = Hash::check(request('current_password'), Auth::user()->password);
      
      if(!$checkCurrentPassword){
          return redirect('/home/profile')->with('error', 'Password does not match');
      }
      $this->validate(request(), [
          "password" => "required|confirmed",
      ]);

      Auth::user()->password = Hash::make(request('password'));
      Auth::user()->save();
      Auth::logout();
      return redirect(route('login'))->with('success', 'Successfully changed password');
    }
}
