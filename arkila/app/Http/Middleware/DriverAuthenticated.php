<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;
class DriverAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(Auth::check()){
        if(Auth::user()->isSuperAdmin() && Auth::user()->isEnable()){
          return redirect('home/vanqueue');
        }

        $customermodule = Feature::where('description','Customer Module')->first();
        if(Auth::user()->isSuperAdmin() || $customermodule->status == 'enable'){
          if(Auth::user()->isCustomer() && Auth::user()->isEnable()){
            return redirect(route('customermodule.user.index'));
          }
          // else{
          //   Auth::logout();
          //   abort(401);
          // }
        }else{
          Auth::logout();
          abort(403);
        }

        $drivermodule = Feature::where('description','Driver Module')->first();
        if(Auth::user()->isSuperAdmin() || $drivermodule->status == 'enable'){
          if(Auth::user()->isDriver() && Auth::user()->isEnable()){
            return $next($request);
          }
          // else{
          //   Auth::logout();
          //   abort(401);
          // }
        }else{
          Auth::logout();
          abort(403);
        }

      }

      abort(401);
    }
}
