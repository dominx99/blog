<?php

namespace dominx99\school\Middleware;

use dominx99\school\Auth\Auth;
use dominx99\school\BaseTestCase;
use dominx99\school\DatabaseTrait;
use Slim\Http\Response;

class AuthMiddlewareTest extends BaseTestCase
{
    use DatabaseTrait;

    /**
     * @dataProvider routesProvider
     */
    public function testThatGuestCannotAccessRoutesProtectedByAuthMiddleware($route)
    {
        $request = $this->newRequest([
            'uri'    => $route,
            'method' => 'get',
        ]);

        $response = $this->app->process($request, new Response());

        $this->assertFalse(empty($response->getHeader('Location')));
        $this->assertSame($this->container->router->pathFor('auth.login'), $response->getHeader('Location')[0]);

        $this->container->auth->authorize(1);

        $response = $this->app->process($request, new Response());
        $this->assertTrue(empty($response->getHeader('Location')));
    }

    public function routesProvider()
    {
        return [
            ['/dashboard'],
        ];
    }
}
