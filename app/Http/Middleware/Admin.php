<?php

namespace App\Http\Middleware;

use App\Constants\HttpStatusCode;
use App\Constants\UserRole;
use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param null                      $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (!(Auth::guard($guard)->user()->role->id == UserRole::ADMIN_ID)) {
            abort(HttpStatusCode::FORBIDDEN);
        }

        return $next($request);
    }
}
