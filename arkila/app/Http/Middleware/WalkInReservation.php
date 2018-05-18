<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;

class WalkInReservation
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
      $walkInReservation = Feature::where('description','Walk-in Reservation')->first();
      if($walkInReservation->status == 'enable'){
          return $next($request);
      }else{
          abort(403);
      }
    }
}
