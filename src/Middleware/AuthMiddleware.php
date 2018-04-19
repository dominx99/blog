<?php

namespace dominx99\school\Middleware;

use dominx99\school\Auth\Auth;

class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!Auth::check()) {
            return $response->withRedirect($this->container->router->pathFor('login'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
