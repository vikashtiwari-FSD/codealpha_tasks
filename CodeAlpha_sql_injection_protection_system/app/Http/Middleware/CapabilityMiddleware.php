<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CapabilityMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
{
    if (!session('capability_verified')) {

        return redirect()
            ->route('security')
            ->with('error', 'Please verify your Capability Code.');

    }

    return $next($request);
}
}
