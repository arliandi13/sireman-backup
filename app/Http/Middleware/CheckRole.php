<?php
namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    public function handle($request, Closure $next, ...$roles)
{
    $userRole = session('user')->role ?? null;

    if (!$userRole || !in_array($userRole, $roles)) {
        return redirect('/')->with('error', 'Anda tidak memiliki akses.');
    }

    return $next($request);
}

}
