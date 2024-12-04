<?php
namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = session('user')->role ?? null;

        // Jika pengguna tidak login
        if (!$userRole) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika pengguna login tetapi tidak memiliki role yang sesuai
        if (!in_array($userRole, $roles)) {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }

}
