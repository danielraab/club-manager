<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     *
     * @throws AuthorizationException
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if ($request->user()?->hasPermission(...explode("|", $permission))) {
            return $next($request);
        }
        throw new AuthorizationException();
    }
}
