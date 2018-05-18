<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;

class WalkInRental
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
      $walkInRental = Feature::where('description','Walk-in Van Rental')->first();
      if($walkInRental->status == 'enable'){
          return $next($request);
      }else{
          abort(403);
      }
    }
}
