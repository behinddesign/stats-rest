<?php

namespace App\Api\Middleware;

use Closure;

class TokenMiddlewareAuthenticate
{
    /**
     * Stupidly simple token based authentication providing jsut enough security that this warrants. Best used over
     * SSL so that it isn't sniffed.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        //Load simple token
        $token = env('TOKEN');
        $requestToken = $request->get('token');

        if (empty($token)) {
            return response('TOKEN not set on .env', 401);
        }

        if (empty($requestToken)) {
            return response('Unauthorized. Token must be supplied as "token=xyz"', 401);
        }

        if ($token != $request->get('token')) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }
}
