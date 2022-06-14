<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiAuthMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return new Response(['message' => 'unauthenticated'], 403);
        }

        return $next($request);
    }
}
