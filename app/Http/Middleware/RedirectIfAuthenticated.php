<?php

namespace App\Http\Middleware;

use App\Services\rbacService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

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
        $adminId = $request->cookie('admin_id');
        if (!$adminId)
        {
            return Redirect::to('/backend/login');
        }
        $url = explode('?', $_SERVER['REQUEST_URI']);

        if (substr($url[0], -1) === '/')
        {
            $url = substr($url[0], 0, (strlen($url[0])-1));
        } else {
            $url = $url[0];
        }

        $url = substr($url, 1);

        if (!$adminId || !rbacService::check($url, $adminId))
        {
           die('没有权限！');
        }

        return $next($request);
    }
}
