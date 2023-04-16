<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Mendapatkan role pengguna yang telah login
                $userRole = Auth::user()->roles;

                // Mengatur redirect home berdasarkan role pengguna
                if ($userRole == 'USER') {
                    return redirect('dashboardCustomer');
                } elseif ($userRole == 'ADMIN') {
                    return redirect('dashboard');
                }
            }
        }

        return $next($request);
    }
}
