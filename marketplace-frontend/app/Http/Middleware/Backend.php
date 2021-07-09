<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Upload;
use Auth;
class Backend
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
        $adminModel = Upload::where('uuid',setting('admin_logo',''))->first();
        $adminLogo = "";        
        if ($adminModel && $adminModel->hasMedia('admin_logo')) {
            $adminLogo = $adminModel->getFirstMediaUrl('admin_logo');
        }

        $iconModel = Upload::where('uuid',setting('icon_logo',''))->first();
        $iconLogo = "";
        if ($iconModel && $iconModel->hasMedia('icon_logo')) {
            $iconLogo = $iconModel->getFirstMediaUrl('icon_logo');
        }

        $user = Auth::user();
        $userImage = "";
        if ($user && $user->hasMedia('avatar')) {
            $userImage = $user->getFirstMediaUrl('avatar','icon');
        }
        view()->share([
          'adminLogo'=> $adminLogo,
          'iconLogo'=> $iconLogo,
          'adminName'=> $user->name,
          'adminImage'=> $userImage,
          ]);

        return $next($request);
    }
}
