<?php

namespace dominx99\school\Middleware;

use PHPUnit\Framework\TestCase;
use Slim\Http\Response;
use dominx99\school\Manager;
use dominx99\school\Auth\Auth;

class AuthMiddlewareTest extends TestCase
{
    use Manager;

    public function setUp()
    {
        $this->create();
    }

    /**
     * @dataProvider routesProvider
     */
    public function testThatGuestCannotAccessRoutesProtectedByAuthMiddleware($route)
    {
        $this->auth->logout();

        $request = $this->newRequest([
            'uri' => $route,
            'method' => 'get'
        ]);

        $response = $this->app->process($request, new Response());

        $this->assertFalse(empty($response->getHeader('Location')));
        $this->assertSame($this->container->router->pathFor('login'), $response->getHeader('Location')[0]);

        $this->register();

        $response = $this->app->process($request, new Response());
        $this->assertTrue(empty($response->getHeader('Location')));
    }

    public function routesProvider()
    {
        return [
            ['/dashboard']
        ];
    }
}
