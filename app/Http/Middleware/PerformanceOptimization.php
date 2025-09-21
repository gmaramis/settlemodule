<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PerformanceOptimization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Add performance headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Add cache headers for static assets
        if ($this->isStaticAsset($request)) {
            $response->headers->set('Cache-Control', 'public, max-age=31536000, immutable');
        } elseif ($this->isApiRequest($request)) {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        } else {
            $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate');
        }

        // Add performance timing
        $response->headers->set('X-Response-Time', microtime(true) - LARAVEL_START);

        return $response;
    }

    /**
     * Check if request is for static asset
     */
    private function isStaticAsset(Request $request): bool
    {
        $path = $request->path();
        return str_contains($path, 'css') || 
               str_contains($path, 'js') || 
               str_contains($path, 'images') || 
               str_contains($path, 'fonts');
    }

    /**
     * Check if request is API request
     */
    private function isApiRequest(Request $request): bool
    {
        return str_starts_with($request->path(), 'api/');
    }
}
