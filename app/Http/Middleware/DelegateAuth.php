<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class DelegateAuth
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
        if (auth()->user()->is_active == 1) {

            if (auth()->user()->company->company_active == 1) {
                if (! ($user == 'delegate')) {
                    return redirect(url($user));
                }
            } else {
                Auth::logout();

                return redirect('/login')->withErrors('هذا الحساب غير مفعل');

            }
        } else {
            Auth::logout();

            return redirect('/login')->withErrors('هذا الحساب غير مفعل');

        }

        return $next($request);
    }
}
