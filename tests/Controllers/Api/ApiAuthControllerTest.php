<?php

namespace dominx99\school\Controllers\Api;

use PHPUnit\Framework\TestCase;
use Slim\Http\Response;
use Slim\App;
use dominx99\school\Manager;
use dominx99\school\Models\User;
use dominx99\school\Auth\Auth;

class ApiAuthControllerTest extends TestCase
{
    use Manager;

    protected $app;
    protected $container;

    public function setUp()
    {
        $this->app = $this->createApplication();
        $this->container = $this->app->getContainer();
        $this->migrate();
    }

    public function testThatApiRegistrationWorks()
    {
        Auth::logout();

        $params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'dddddd'
        ];

        $request = $this->newRequest([
            'uri' => 'api/register',
            'method' => 'post',
            'content_type' => 'application/json'
        ], $params);

        $app = $this->app;
        $response = $app($request, new Response());

        $exists = User::where('email', $params['email'])->exists();

        $expected = json_encode([
            'status' => 'success',
            'code' => 200
        ]);

        $authorized = Auth::check();
        $email = Auth::user()->email;

        $this->assertTrue($exists);
        $this->assertTrue($authorized);
        $this->assertEquals($email, $params['email']);
        $this->assertEquals($expected, $response->getBody());
    }

    public function testThatApiValidatesData()
    {
        $params = [
            'email' => 'ddd.com', // bad email
            'name' => '', // name cannot be empty
            'password' => 'abc' // passwod is too short (6, 16)
        ];

        $request = $this->newRequest([
            'uri' => 'api/register',
            'method' => 'post',
            'content_type' => 'application/json'
        ], $params);

        $app = $this->app;
        $response = $app($request, new Response());

        $exists = User::where('email', $params['email'])->exists();

        $expected = [
            'status' => 'fail',
            'code' => 300
        ];

        $expected = json_encode($expected);

        $this->assertFalse($exists);
        $this->assertEquals($expected, $response->getBody());
    }
}
