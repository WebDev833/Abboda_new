<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Session;

class Frontend
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
        // get Updated settings from backend
        //dd(Session::all());
       // session(['language' => 'test']);
        //session::regenerate();
        $defSettings = config('roms.frontSettings');
        array_map(function($key){
            $settingVal = setting($key);
            if(!is_null($settingVal))
             return Config::set('roms.frontSettings.'.$key,$settingVal);
        },$defSettings);
        
      // set default lang to english (en) : whatever in settings
      if (Session::has('language')) 
      {
        \App::setLocale(Session::get('language'));
      } else 
      {
        \App::setLocale(Config::set('roms.frontSettings.front_app_language'));
      }
      return $next($request);
    }
}
