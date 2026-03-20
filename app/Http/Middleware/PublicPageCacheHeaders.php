<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicPageCacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        if ($request->isMethod('GET') && $response->isSuccessful()) {
            $contentType = (string) $response->headers->get('Content-Type', '');

            if (
                str_contains($contentType, 'text/html') ||
                str_contains($contentType, 'application/xml') ||
                str_contains($contentType, 'text/plain')
            ) {
                $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=300, stale-while-revalidate=60');
                $response->headers->remove('Pragma');
                $response->headers->remove('Expires');
            }
        }

        return $response;
    }
}
