<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateN8n
{
    /**
     * Handle an incoming request from n8n webhook.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $expectedKey = config('services.n8n.api_key');

        if (empty($expectedKey)) {
            return response()->json([
                'message' => 'N8N API key not configured'
            ], 500);
        }

        // Check Authorization Bearer token
        $authHeader = $request->bearerToken();

        if ($authHeader !== $expectedKey) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}
