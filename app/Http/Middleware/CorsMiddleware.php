<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowed_origins = Config::get('cors.allowed_origins', []);
        $allowed_patterns = Config::get('cors.allowed_origins_patterns', []);
        $origin = $request->header('Origin') ?: $request->header('Referer');

        // Check if origin is allowed
        $isAllowed = in_array('*', $allowed_origins) || 
                     in_array($origin, $allowed_origins) || 
                     $this->matchesPattern($origin, $allowed_patterns);

        // Log for debugging
        \Log::debug('CORS Check', [
            'origin' => $origin,
            'method' => $request->method(),
            'path' => $request->path(),
            'is_allowed' => $isAllowed,
        ]);

        // Handle preflight requests
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', $isAllowed ? $origin : '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '3600');
        }

        $response = $next($request);

        // Add CORS headers to response
        if ($isAllowed) {
            $response->header('Access-Control-Allow-Origin', $origin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, Accept, Origin')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '3600');
        }

        return $response;
    }

    private function matchesPattern($origin, $patterns)
    {
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $origin)) {
                return true;
            }
        }
        return false;
    }
}
