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
        if($user->status == 'disable'){
          Auth::logout();
          dd('HEHEHE');
          return back()->with('error', 'You need to confirm your account. We have sent you an activation link, please check your email.');
        }else if($user->status === 'enable'){
          $customermodule = Feature::where('description','Customer Module')->first();
          if($customermodule->status == 'enable'){
            if($user->isCustomer() && $user->isEnable()){
              return redirect(route('customermodule.user.index'));
            }
          }else{
            abort(403);
          }


          $drivermodule = Feature::where('description','Driver Module')->first();
          if($drivermodule->status == 'enable'){
            if($user->isDriver() && $user->isEnable()){
              return redirect(route('drivermodule.index'));
            }
          }else{
            abort(403);
          }


          if($user->isSuperAdmin() && $user->isEnable()){
            $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
            if($mainterminal){
              return redirect('getting-started/setup');
            }else{
              return redirect('home/vanqueue');
            }

          }

        }

        abort(401);
    }
}
