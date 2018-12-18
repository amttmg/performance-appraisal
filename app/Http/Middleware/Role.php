<?php

namespace App\Http\Middleware;

use App\Constants\HttpStatusCode;
use App\Constants\UserRole;
use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param                           $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $role = Auth::user()->role->title;
        if (!(in_array(strtolower($role),$roles))) {
            abort(HttpStatusCode::FORBIDDEN);
        }

        return $next($request);
    }
}
