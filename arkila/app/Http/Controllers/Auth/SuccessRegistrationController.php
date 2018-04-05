<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SuccessRegistrationController extends Controller
{
    public function successRegistration()
    {
      return view('auth.registrationSuccess');
    }
}
