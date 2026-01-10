<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AllowIframe
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);

        // Izinkan iframe dari mana saja
        $response->headers->remove('X-Frame-Options');

        $response->headers->set(
            'Content-Security-Policy',
            "frame-ancestors *"
        );

        return $response;
    }
}
