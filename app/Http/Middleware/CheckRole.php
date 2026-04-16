<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Periksa apakah pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role pengguna
        $userRole = Auth::user()->role;

        // Periksa apakah role pengguna termasuk dalam array $roles
        if (!in_array($userRole, $roles)) {
            return abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
