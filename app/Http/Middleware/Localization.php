<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if ($request->hasHeader("Accept-Language")) {
        //     /**
        //      * If Accept-Language header found then set it to the default locale
        //      */
        //     App::setLocale($request->header("Accept-Language"));
        // }
        if (Session::has('api_language')) {
            App::setLocale(Session::get('api_language'));
        }

        return $next($request);
    }
}
