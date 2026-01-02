<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Vérifie si l'utilisateur connecté a le rôle attendu
     * Usage dans route : ->middleware('role:admin') ou ->middleware('role:vendor')
     */
    public function handle($request, Closure $next, ...$roles)
{
    if (!auth::check()) {
        abort(403);
    }

    if (!in_array(auth::user()->role, $roles)) {
        abort(403);
    }

    return $next($request);
}

}
