<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;
class SuperAdminAuthenticated
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
          $customermodule = Feature::where('description','Customer Module')->first();
          if(Auth::user()->isSuperAdmin() ||$customermodule->status == 'enable'){
            if(Auth::user()->isCustomer() && Auth::user()->isEnable()){
              return redirect(route('customermodule.user.index'));
            }
          }else{
            abort(403);
          }

          $drivermodule = Feature::where('description','Driver Module')->first();
          if(Auth::user()->isSuperAdmin() || $drivermodule->status == 'enable'){
            if(Auth::user()->isDriver() && Auth::user()->isEnable()){
              return redirect(route('drivermodule.index'));
            }
          }else{
            abort(403);
          }


          if(Auth::user()->isSuperAdmin() && Auth::user()->isEnable()){
            return $next($request);
          }
        }

        abort(404);
    }
}
