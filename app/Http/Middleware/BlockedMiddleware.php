<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockedMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isBlocked()) {
            abort(403, 'Your account has been blocked.');
        }

        return $next($request);
    }
}