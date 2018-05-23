<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
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
      // if(Auth::user()->isSuperAdmin() && Auth::user()->isEnable()){
      //   $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
      //   if($mainterminal){
      //     return $next($request);  
      //     //return redirect('getting-started/setup');
      //   }else{
      //     return redirect('home/vanqueue');
      //     //return $next($request);
      //   }
      // }

      $mainterminal = (Destination::where('is_main_terminal', true)->select('destination_name')->first() == null ? true : false);
        if($mainterminal == true){
          //dd('HI');  
          return redirect('getting-started/setup');
        }else{
          return $next($request);
        }

        
    }
}
