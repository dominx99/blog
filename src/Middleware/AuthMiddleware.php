<?php

namespace dominx99\school\Middleware;

/**
 * @property object router
 * @property object auth
 */
class AuthMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->auth->check()) {
            return $response->withRedirect($this->router->pathFor('login'));
        }

        $response = $next($request, $response);
        return $response;
    }
}
