<?php

namespace dominx99\school\Middleware;

use dominx99\school\BaseTestCase;
use Slim\Http\Response;
use dominx99\school\DatabaseTrait;

class GuestMiddlewareTest extends BaseTestCase
{
    use DatabaseTrait;

    /**
     * @dataProvider routesProvider
     */
    public function testThatUserCannotAccessRoutesProtectedByGuestMiddleware($route)
    {
        $this->container->auth->authorize(1);

        $request = $this->newRequest([
            'uri' => $route,
            'method' => 'get'
        ]);

        $response = $this->app->process($request, new Response());

        $this->assertFalse(empty($response->getHeader('Location')));
        $this->assertSame($this->container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);

        $this->container->auth->logout();

        $response = $this->app->process($request, new Response());
        $this->assertTrue(empty($response->getHeader('Location')));
    }

    public function routesProvider()
    {
        return [
            ['/login'],
            ['/register']
        ];
    }
}
