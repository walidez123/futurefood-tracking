<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class ClientAuth
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
        if (auth()->user()->company != null) {

            if (auth()->user()->company->company_active == 1) {
                if (! ($user == 'client')) {
                    return redirect(url($user));
                }
            } else {
                Auth::logout();

                return redirect('/login')->withErrors('هذا الحساب غير مفعل');

            }
        }
        if (! ($user == 'client')) {
            return redirect(url($user));
        }

        return $next($request);
    }
}
