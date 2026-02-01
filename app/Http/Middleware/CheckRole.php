<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  Roles yang diizinkan mengakses route
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // Redirect ke login jika belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // Jika tidak ada role yang ditentukan, izinkan akses
        if (empty($roles)) {
            return $next($request);
        }

        // Cek apakah role user termasuk dalam daftar roles yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
