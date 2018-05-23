<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if($request->user()->isSuperAdmin() && $request->user()->isEnable()){
                return redirect('home/vanqueue');
            }else if($request->user()->isDriver() && $request->user()->isEnable()){
                return redirect(route('drivermodule.index'));
            }else if($request->user()->isCustomer() && $request->user()->isEnable()){
                return redirect(route('customermodule.user.index'));
            }    
        }
        

        return $next($request);
    }
}
