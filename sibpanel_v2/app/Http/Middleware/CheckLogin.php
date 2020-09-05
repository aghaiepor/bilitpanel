<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('SessionId') || !session()->has('UserInfo') ) {
           /* if(!session()->has('url.intended'))
            {
                session(['url.intended' => url()->previous()]);
            }*/
            return redirect('login');
        }
            return $next($request);
    }
}

