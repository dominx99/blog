<?php

namespace dominx99\school\Middleware;

/**
 * @property object router
 * @property object auth
 */
class GuestMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if ($this->auth->check()) {
            return $response->withRedirect($this->router->pathFor('dashboard'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
