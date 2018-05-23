<?php

namespace App\Http\Middleware;

use Closure;
use function MongoDB\BSON\toJSON;
use Symfony\Component\HttpFoundation\Response as Http;

class ApiCheckAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (! auth()->check() || ! auth()->user()->confirmed) {
            return Response('Unauthenticated', Http::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
