<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = NULL)
    {
      if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('login'))->with('error',trans('front.must_be_logged_in'));
            }
        } elseif (!Auth::user()->userType(3)) { // 3 for manager
            return redirect()->to('/')->withError('Permission Denied');
        }
        return $next($request);
    }
}
