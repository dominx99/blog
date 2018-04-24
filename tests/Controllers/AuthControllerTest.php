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

    protected function setUp()
    {
        $this->create();
        $this->auth->logout();
    }

    public function testThatRegisterWorks()
    {
        $app = $this->app;
        $container = $this->app->getContainer();

        $response = $this->register();

        $user = User::where('email', 'ddd@ddd.com')->first();

        $this->assertTrue($this->auth->check());
        $this->assertEquals($this->auth->user()->email, $this->params['email']);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertFalse(empty($user));
        $this->assertSame($container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);
    }

    public function testThatRegistrationWithWrongDataWillRedirectBack()
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

        $userExists = User::where('email', 'ddd@ddd.com')->exists();

        $this->assertFalse($userExists);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSame($container->router->pathFor('register'), $response->getHeader('Location')[0]);
    }

    /**
     * @depends testThatRegisterWorks
     */
    public function testThatLoginWorks()
    {
        $app = $this->app;
        $container = $this->app->getContainer();

        $this->register();
        $this->auth->logout();

        $request = $this->newRequest([
            'uri' => '/login',
            'method' => 'post'
        ], $this->params);

        $response = $app($request, new Response());

        $user = User::where('email', $this->params['email'])->first();

        $this->assertTrue($this->auth->check());
        $this->assertEquals($this->auth->user(), $user);
        $this->assertSame($container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);
    }

    /**
     * @depends testThatRegisterWorks
     * @dataProvider loginDataProvider
     */
    public function testThatLoginWrongDataRedirectsBack($email, $password)
    {
        $app = $this->app;
        $container = $this->app->getContainer();

        $this->register();
        $this->auth->logout();

        $params = [
            'email' => $email,
            'password' => $password
        ];

        $request = $this->newRequest([
            'uri' => '/login',
            'method' => 'post'
        ], $params);

        $response = $app($request, new Response());

        $this->assertFalse($this->auth->check());
        $this->assertSame($container->router->pathFor('login'), $response->getHeader('Location')[0]);
    }

    public function loginDataProvider()
    {
        return [
           ['ddd.com', 'dddddd'],
           ['ddd@ddd.com', 'ddd']
       ];
    }
}
