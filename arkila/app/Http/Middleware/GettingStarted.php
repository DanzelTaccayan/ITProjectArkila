<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Feature;
use App\Destination;

class GettingStarted
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
      $setup =  Feature::where('description','SetUp Page')->first();
      $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
      if((Auth::user()->isSuperAdmin()) && ($setup->status == 'enable' && $mainterminal == true)){
        return redirect('/getting-started/setup');
      }else{
        return $next($request);
      }        
    }
}
