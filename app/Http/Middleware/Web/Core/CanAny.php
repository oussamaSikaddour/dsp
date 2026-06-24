<?php

namespace App\Http\Middleware\Web\Core;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CanAny
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$abilities): Response
    {
        foreach ($abilities as $ability) {
            if (Gate::allows($ability)) {
                return $next($request);
            }
        }

        abort(403);
    }
}
