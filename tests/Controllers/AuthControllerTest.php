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
            'password' => 'dddddd' // password is too short (6, 16)
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

    public function testThatRegistrationWithWrongDataWillRedirectBack()
    {
        // TODO: TEST email Validation
        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'ddd' // password is too short (6, 16)
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post'
        ], $params);

        $response = ($this->app)($request, new Response());

        $userExists = User::where('email', $params['email'])->exists();

        $this->assertFalse($userExists);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSame($this->container->router->pathFor('register'), $response->getHeader('Location')[0]);
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
        $this->assertSame($this->container->router->pathFor('login'), $response->getHeader('Location')[0]);
    }

    public function loginDataProvider()
    {
        return [
           ['aaa.com', 'abcabc'],
           ['aaa@aaa.com', 'aaa']
       ];
    }
}
