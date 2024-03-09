<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof \Illuminate\Http\Response) {
            $response->header('Access-Control-Allow-Origin', '*');
            $response->header('Access-Control-Allow-Headers', 'Content-Type', 'Accept', 'Authorization');
        }

        return $response;
    }
}
