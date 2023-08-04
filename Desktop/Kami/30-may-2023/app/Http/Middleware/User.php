<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
class User
{
    
    public function handle(Request $request, Closure $next)
    {
        if(Auth::guard('users')->user() && Auth::guard('users')->user()->is_phone_verified =='1'){
        //    return $next($request);     
           return redirect::route('UserLoginOtp');     
        }
        return redirect::route('UserLogin');
    }



}
