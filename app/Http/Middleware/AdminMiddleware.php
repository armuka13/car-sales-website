<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // 1. Basic Auth & Admin Check
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(404);
        }

        return $next($request);
    }
}