<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use App\Destination;
use App\Feature;
use Illuminate\Http\Request;
use Auth;
use Closure;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function username()
    {
      return 'username';
    }

    public function authenticated(Request $request, $user)
    {
        $customermodule = Feature::where('description','Customer Module')->first();
        $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
        if($mainterminal == true){
          return redirect()->back()->withErrors('Your credentials does not match');
        }else{
          if($customermodule->status == 'enable'){
            if($user->isCustomer()){
              if($user->isEnable()){
                return redirect(route('customermodule.user.index'));
              }else{
                Auth::logout();
                return redirect()->back()->withErrors('You need to confirm your account. We have sent you an activation link to your e-mail address');
              }
            }
          }else{
            return redirect()->back();
          }
        }

        $drivermodule = Feature::where('description','Driver Module')->first();
        if($mainterminal == true){
          return redirect()->back()->withErrors('Your credentials does not match');
        }else{
          if($drivermodule->status == 'enable'){
            if($user->isDriver()){
              if($user->isEnable()){
                return redirect(route('drivermodule.index'));
              }else{
                Auth::logout();
                return redirect()->back()->withErrors('Your user account has been disabled by the administrator. Contact the administrator if you have any concerns'); 
              }
            }
          }else{
            return redirect()->back();
          }
        }

        if($user->isSuperAdmin() && $user->isEnable()){
          $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
          if($mainterminal){
            return redirect('getting-started/setup');
          }else{
            return redirect('home/vanqueue');
          }
        }

        abort(401);
    }
}
