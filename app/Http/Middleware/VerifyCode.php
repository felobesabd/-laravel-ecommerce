<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class VerifyCode
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
        if (Auth::guard('web')->check()) {
            if (Auth::user()->mobile_verified_at == null) {
                return redirect(RouteServiceProvider::VERIFY);
            }
        }
        return $next($request);
    }
}
