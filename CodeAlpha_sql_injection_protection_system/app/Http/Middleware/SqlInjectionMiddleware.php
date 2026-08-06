<?php

namespace App\Http\Middleware;
use App\Models\AttackLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class SqlInjectionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
{
    $patterns = [
        "/(\%27)|(\')|(\-\-)|(\%23)|(#)/i",
        "/\b(OR|AND)\b\s+\d+\s*=\s*\d+/i",
        "/UNION\s+SELECT/i",
        "/DROP\s+TABLE/i",
        "/DELETE\s+FROM/i",
        "/INSERT\s+INTO/i",
        "/UPDATE\s+\w+/i",
        "/information_schema/i",
        "/xp_cmdshell/i",
        "/EXEC(\s|\+)/i",
    ];

    foreach ($request->all() as $field => $value) {

        if (!is_string($value)) {
            continue;
        }

        foreach ($patterns as $pattern) {

            if (preg_match($pattern, $value)) {

                AttackLog::create([
    'ip_address'      => $request->ip(),
    'request_method'  => $request->method(),
    'route'           => $request->path(),
    'user_agent'      => $request->userAgent(),
    'attempted_input' => $value,
    'attack_type'     => 'SQL Injection',
    'status'          => 'Blocked',
]);

                abort(403, 'SQL Injection attempt detected.');
            }
        }
    }

    return $next($request);
}
}
