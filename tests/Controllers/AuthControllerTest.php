<?php

namespace dominx99\school\Controllers;

use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface;
use dominx99\school\App;
use dominx99\school\Manager;
use dominx99\school\Models\User;
use dominx99\school\Auth\Auth;
use dominx99\school\Csrf\Csrf;

session_start();

class AuthControllerTest extends TestCase
{
    use Manager;

    protected $app;
    protected $guard;

    public function setUp()
    {
        $this->app = $this->createApplication();
        $this->migrate();

        Auth::logout();
    }

    public function testThatRegisterWorks()
    {
        $app = $this->app;
        $container = $this->app->getContainer();

        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'dddddd'
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post',
        ], $params);

        $response = $app($request, new Response());

        $user = User::where('email', 'ddd@ddd.com')->first();

        $this->assertTrue(Auth::check());
        $this->assertEquals(Auth::user()->email, $params['email']);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertFalse(empty($user));
        $this->assertSame($container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);
    }

    public function testThatQueryWithWrongDataWillRedirectBack()
    {
        $app = $this->app;
        $container = $this->app->getContainer();

        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'ddd' // password is too short (6, 16)
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post'
        ], $params);

        $response = $app($request, new Response());

        $user = User::where('email', 'ddd@ddd.com')->first();

        $this->assertTrue(empty($user));
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSame($container->router->pathFor('register'), $response->getHeader('Location')[0]);
    }
}
