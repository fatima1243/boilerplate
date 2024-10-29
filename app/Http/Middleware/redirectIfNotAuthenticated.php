<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class redirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ((((Auth::guard('driver')->check()) && (Auth::guard('driver')->user()->email_verified_at != null) && (Auth::guard('driver')->user()->is_blocked == '1')) ||  ((Auth::guard('recruiter')->check())) && (Auth::guard('recruiter')->user()->email_verified_at != null) && ((Auth::guard('recruiter')->user()->is_blocked == '1')))) {
            return $next($request);
        }
        if (Auth::guard('recruiter')->check()) {
            Session::flush();
            Auth::guard('recruiter')->user()->logout;
        } else if (Auth::guard('driver')->check()) {
            Session::flush();
            Auth::guard('driver')->user()->logout;
        }
        return redirect()->route('recruiter/register');
    }
}
