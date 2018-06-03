<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;

class OnlineRental
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
        $onlineRental = Feature::where('description','Online Van Rental')->first();
        if(Auth::user()->isSuperAdmin() || $onlineRental->status == 'enable'){
            return $next($request);
        }else{
            abort(503);
        }

    }
}
