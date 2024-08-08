<?php

namespace App\Http\Middleware;

use Closure;

class Super_AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user()->user_type;
        if (! ($user == 'super_admin')) {
            return redirect(url($user));
        }

        return $next($request);
    }
}
