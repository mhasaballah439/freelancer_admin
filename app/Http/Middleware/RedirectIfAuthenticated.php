<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if ($guard == 'admin')
                return redirect()->route('dashboard.index');
        }
        elseif (Auth::guard($guard)->check()) {
            if ($guard == 'web')
                return redirect()->route('user.dashboard.index');
        }
        elseif (Auth::guard($guard)->check()) {
            if ($guard == 'distributor')
                return redirect()->route('distributor.dashboard.index');
        }
        else {
            return redirect()->route('user.login');
        }

        return $next($request);
    }
}
