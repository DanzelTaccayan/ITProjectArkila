<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;

class OnlineReservation
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
      $onlineReservation = Feature::where('description','Online Reservation')->first();
      if(Auth::user()->isSuperAdmin() || $onlineReservation->status == 'enable'){
          return $next($request);
      }else{
          abort(403);
      }
    }
}
