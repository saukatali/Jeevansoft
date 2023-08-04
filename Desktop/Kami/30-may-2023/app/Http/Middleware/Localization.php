<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;
use Closure;
use Illuminate\Http\Request;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Session::has('languageName')) {
        //     App::setLocale(Session::get('languageName'));
        // }

        if (session()->has('locale')) {
 
            App::setLocale(session()->get('locale'));
 
        }
 
        return $next($request);
    }
}
