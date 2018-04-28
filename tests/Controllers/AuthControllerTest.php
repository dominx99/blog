<?php

namespace dominx99\school\Controllers;

use dominx99\school\BaseTestCase;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface;
use dominx99\school\App;
use dominx99\school\DatabaseTrait;
use dominx99\school\Models\User;
use dominx99\school\Auth\Auth;
use dominx99\school\Csrf\Csrf;

class AuthControllerTest extends BaseTestCase
{
    use DatabaseTrait;

    public function testThatRegisterWorks()
    {
        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'dddddd'
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post'
        ], $params);

        $response = ($this->app)($request, new Response());

        $user = User::where('email', $this->user['email'])->first();

        $this->assertTrue($this->container->auth->check());
        $this->assertEquals($this->container->auth->user()->email, $params['email']);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertFalse(empty($user));
        $this->assertSame($this->container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);
    }

    /**
     * @dataProvider registerDataProvider
     */
    public function testThatRegistrationWithWrongDataWillRedirectBack($email, $password)
    {
        // TODO: TEST email Validation
        $params = [
            'email' => $email,
            'name' => 'ddd',
            'password' => $password
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post'
        ], $params);

        $response = ($this->app)($request, new Response());

        $userExists = User::where('email', $params['email'])->exists();

        $this->assertFalse($userExists);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSame($this->container->router->pathFor('auth.register'), $response->getHeader('Location')[0]);
    }

    public function testEmailAvaibleRule()
    {
        $request = $this->newRequest([
            'uri' => 'register',
            'method' => 'post'
        ], $this->user);

        $response = $this->app->process($request, new Response());

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals($this->container->router->pathFor('auth.register'), $response->getHeader('Location')[0]);
    }

    /**
     * @depends testThatRegisterWorks
     */
    public function testThatLoginWorks()
    {
        $request = $this->newRequest([
            'uri' => '/login',
            'method' => 'post'
        ], $this->user);

        $response = ($this->app)($request, new Response());

        $user = User::where('email', $this->user['email'])->first();

        $this->assertTrue($this->container->auth->check());
        $this->assertEquals($this->container->auth->user(), $user);
        $this->assertSame($this->container->router->pathFor('dashboard'), $response->getHeader('Location')[0]);
    }

    /**
     * @depends testThatRegisterWorks
     * @dataProvider loginDataProvider
     */
    public function testThatLoginWrongDataRedirectsBack($email, $password)
    {
        $params = [
            'email' => $email,
            'password' => $password
        ];

        $request = $this->newRequest([
            'uri' => '/login',
            'method' => 'post'
        ], $params);

        $response = ($this->app)($request, new Response());

        $this->assertFalse($this->container->auth->check());
        $this->assertSame($this->container->router->pathFor('auth.login'), $response->getHeader('Location')[0]);
    }

    public function loginDataProvider()
    {
        return [
           ['aaa.com', 'abcabc'],
           ['aaa@aaa.com', 'aaa']
       ];
    }

    public function registerDataProvider()
    {
        return [
            ['ddd@ddd.com', 'ddd'], // password too shord (6, 16)
            ['ccc@', '12345678'],
            ['ccc.com', 'cccaaa']
        ];
    }
}
