<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
              //dd('una');
                return redirect()->guest(route('login'))->with('error',trans('front.must_be_logged_in'));
            }
        } elseif (!Auth::user()->userType(5)) { // 5 for client
            return redirect()->to('/')->with('error','Permission Denied');
        }
        return $next($request);
    }
}
