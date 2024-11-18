<?php
namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    public function handle($request, Closure $next, $role)
{
    $user = session('user');
    if ($user && $user->role === $role) {
        return $next($request);
    }

    return redirect('/login')->withErrors(['Unauthorized access']);
}
}
