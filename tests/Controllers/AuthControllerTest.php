<?php

namespace dominx99\school\Controllers;

use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;

use dominx99\school\App;
use dominx99\school\Manager;
use dominx99\school\Models\User;

class AuthControllerTest extends TestCase
{
    use Manager;

    protected $app;

    public function setUp()
    {
        $this->app = $this->createApplication();
        $this->migrate();
    }

    public function testThatRegisterWorks()
    {
        $container = $this->app->getContainer();

        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'dddddd'
        ];

        $params = http_build_query($params);

        $container['environment'] = function() use ($params) {
            return Environment::mock([
                'REQUEST_URI' => '/register',
                'REQUEST_METHOD' => 'POST',
                'QUERY_STRING' => $params
            ]);
        };

        $response = $this->app->run(true);

        $user = User::where('email', 'ddd@ddd.com')->first();

        $this->assertFalse(empty($user));
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSame($container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);
    }

    public function testThatQueryWithWrongDataWillRedirectBack()
    {
        $container = $this->app->getContainer();

        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'ddd' // password is too short (6, 16)
        ];

        $params = http_build_query($params);

        $container['environment'] = function() use ($params) {
            return Environment::mock([
                'REQUEST_URI' => '/register',
                'REQUEST_METHOD' => 'POST',
                'QUERY_STRING' => $params
            ]);
        };

        $response = $this->app->run(true);

        $user = User::where('email', 'ddd@ddd.com')->first();

        $this->assertTrue(empty($user));
        $this->assertEquals($container->router->pathFor('register'), $response->getHeader('Location')[0]);
    }
}
