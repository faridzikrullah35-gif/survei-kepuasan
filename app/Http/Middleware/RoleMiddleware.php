<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Menangani permintaan yang masuk.
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // Periksa apakah role pengguna termasuk dalam daftar $roles
        if (!in_array(auth()->user()->role, $roles)) {
            return abort(403, 'Aksi tidak diizinkan.');
        }
        
        return $next($request);
    }
}
