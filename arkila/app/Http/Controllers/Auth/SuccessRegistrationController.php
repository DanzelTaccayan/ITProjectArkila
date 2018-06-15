<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuccessRegistrationController extends Controller
{
    public function __contruct()
    {
      $this->middleware('prevent-back-registration-success');
    }
    public function successRegistration()
    {
      if(session('registrationsuccess')) {
        return view('auth.registrationSuccess');
      } else {
        return redirect('/login');
      }
    }
}
