<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectByRole
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect('/dashboard');
            } else {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
