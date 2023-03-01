<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddContentLengthHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $responsecontent = $response->getContent();
        if($responsecontent) {
            $response->headers->set('Content-Length', strval(strlen($responsecontent)));
        };

        return $response;
    }
}
