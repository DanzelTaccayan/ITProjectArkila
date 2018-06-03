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
          if(Auth::user()->isSuperAdmin() || $customermodule->status == 'enable'){
            if(Auth::user()->isCustomer()){
              if(Auth::user()->isEnable()){
                return redirect(route('customermodule.user.index'));  
              }else{
                Auth::logout();
                abort(403);
              } 
            }
          }else{
            Auth::logout();
            abort(403);
          }

          $drivermodule = Feature::where('description','Driver Module')->first();
          if(Auth::user()->isSuperAdmin() || $drivermodule->status == 'enable'){
            if(Auth::user()->isDriver()){
              if(Auth::user()->isEnable()){
                return redirect(route('drivermodule.index'));
              }else{
                Auth::logout();
                abort(403);
              }
            }
            
          }else{
            Auth::logout();
            abort(403);
          }


          if(Auth::user()->isSuperAdmin() && Auth::user()->isEnable()){
            return $next($request);
          }
        }

        abort(401);
    }
}
