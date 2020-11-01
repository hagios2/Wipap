<?php

namespace App\Http\Middleware;

use Closure;

class isSuperAdmin
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
        if(auth()->guard('wmc_admin')->check())
        {
            $user = auth()->guard('wmc_admin')->user();

            if($user->role->role == 'super_admin')
            {
                return $next($request);
            }

            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json(['message' => 'Unauthenticated'], 401);
    }

}
