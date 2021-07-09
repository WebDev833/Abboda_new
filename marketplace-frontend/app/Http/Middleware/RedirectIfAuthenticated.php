<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
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
        $for = [
                '5' => 'home',
                '2'  => 'admin.dashboard',
                '3'=>'manager.dashboard',
                '4'=>'driver.dashboard'
            ];
           
        if (Auth::guard($guard)->check()) {

            // if($request->ajax()){
            //     return response()->json( ['success'=>route($for[Auth::user()->user_type])]);
            // }
            
           
              return redirect()->route($for[Auth::user()->user_type]);
        }
       
        return $next($request);
    }
}
