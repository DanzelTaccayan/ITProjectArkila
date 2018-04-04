<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use App\User;


class CustomerUserManagementController extends Controller
{
    public function show(User $customer_user)
    {

        return view('usermanagement.editCustomer', compact('customer_user'));
    }

    public function update(User $customer_user)
    {
        $defaultpassword = "customer!@bantrans";

        $customer_user->password = Hash::make($defaultpassword);
        $customer_user->save();
        $customerName = $customer_user->first_name . " " . $customer_user->middle_name . " " . $customer_user->last_name;

        return redirect('/home/user-management')->with('success', 'Password reset successful for ' . $customerName . '');
    }

    public function changeCustomerStatus()
    {
        $id = Input::get('id');

        // dd($id);
        $user = User::findOrFail($id);
        if($user->status === "enable"){
            $user->status = "disable";
            session()->flash('message', 'User successfully enabled!');
        }elseif($user->status === "disable"){
            $user->status = "enable";

            session()->flash('message', 'User successfully disabled!');
        }

        $user->save();
        return response()->json($user);
    }
}
