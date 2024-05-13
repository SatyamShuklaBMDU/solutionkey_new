<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        if ($request->user()->hasPermission('all')) {
            return $next($request);
        }
        foreach ($permissions as $permission) {
            if (!$request->user()->hasPermission($permission)) {
                abort(403, 'Unauthorized action.');
            }
        }    
        return $next($request);
    }
}
