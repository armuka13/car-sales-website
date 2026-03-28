<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $requiredToken = env('ADMIN_TOKEN');

        if ($requiredToken) {
            // 1. Check if token is provided in the URL query (?token=...)
            if ($request->query('token') === $requiredToken) {
                // Persist it to the session so the user doesn't have to provide it on every subpage
                $request->session()->put('admin_auth_token', $requiredToken);
            }

            // 2. Verify if the session has the valid token
            if ($request->session()->get('admin_auth_token') !== $requiredToken) {
                // If the token is missing/invalid, hide the page behind a 404
                abort(404);
            }
        }

        return $next($request);
    }
}
