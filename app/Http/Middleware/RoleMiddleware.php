<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// class RoleMiddleware
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  Closure(Request): (Response)  $next
//      */
//     public function handle($request, Closure $next, $role)
//     {
//         if (auth()->user()->role !== $role) {
//             abort(403);
//         }
//         return $next($request);
//     }
// }

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check()) {
            $loginRoute = match ($role) {
                'admin' => 'admin.login.form',
                'user' => 'user.login.form',
                default => 'login',
            };

            return redirect()->route($loginRoute);
        }

        if (auth()->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}