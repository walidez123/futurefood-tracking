<?php

namespace App\Http\Middleware;

use Closure;

class TermsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user()->read_terms;
        if ($user == 0) {
            return redirect()->route('terms.show');
        }

        return $next($request);
    }
}
