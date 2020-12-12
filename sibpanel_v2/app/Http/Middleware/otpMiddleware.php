<?php

namespace App\Http\Middleware;

use Closure;

class otpMiddleware
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
        if(session()->has('otpAccept'))
            $otpAccept  = false ;
        else
            $otpAccept = true ;

        if ( session('UserInfo')['otp_verify'] && $otpAccept  ) {
            return redirect('otp');
        }
        return $next($request);
    }
}
