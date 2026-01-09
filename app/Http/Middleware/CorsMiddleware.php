<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowed_origins = [
           '*'
        ];

        $origin = $request->header('Origin') ?: $request->header('Referer');
        
        // Log for debugging
        \Log::debug('CORS Check', [
            'origin' => $origin,
            'method' => $request->method(),
            'path' => $request->path(),
            'is_allowed' => in_array($origin, $allowed_origins),
        ]);

        // Handle preflight requests
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', in_array($origin, $allowed_origins) ? $origin : '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '3600');
        }

        $response = $next($request);

        // Add CORS headers to response
        $response->header('Access-Control-Allow-Origin', in_array($origin, $allowed_origins) ? $origin : '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin')
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Max-Age', '3600');

        return $response;
    }
}
