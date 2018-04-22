<?php

namespace dominx99\school\Controllers\Api;

use PHPUnit\Framework\TestCase;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Slim\Http\Response;
use Slim\App;
use dominx99\school\Manager;
use dominx99\school\Models\User;
use dominx99\school\Auth\Auth;
use dominx99\school\Config;

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
        Auth::logout();
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

        $userExists = User::where('email', $params['email'])->exists();

        $this->assertTrue($userExists);
        $this->assertTrue(Auth::check());
        $this->assertEquals(Auth::user()->email, $params['email']);

        $signer = new Sha256();
        $key = Config::get('jwtKey');

        $token = (string) (new Builder)
            ->set('id', Auth::user()->id)
            ->sign($signer, $key)
            ->getToken();

        $expected = json_encode([
            'token' => $token,
            'status' => 'success',
            'code' => 200
        ]);

        $authToken = Auth::getToken();

        $this->assertEquals($token, $authToken);
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

        $userExists = User::where('email', $params['email'])->exists();

        $expected = [
            'status' => 'fail',
            'code' => 300
        ];

        $expected = json_encode($expected);

        $this->assertFalse($userExists);
        $this->assertEquals($expected, $response->getBody());
    }

    public function testThatApiLoginWokrs()
    {
        $this->register();
        Auth::logout();

        $request = $this->newRequest([
            'uri' => 'api/login',
            'method' => 'post',
            'content_type' => 'application/json'
        ], $this->params);

        $response = ($this->app)($request, new Response());

        $this->assertTrue(Auth::check());

        $signer = new Sha256();
        $key = Config::get('jwtKey');

        $token = (string) (new Builder)
            ->set('id', Auth::user()->id)
            ->sign($signer, $key)
            ->getToken();

        $expected = [
            'token' => $token,
            'status' => 'success',
            'code' => 200
        ];

        $expected = json_encode($expected);

        $this->assertEquals($expected, $response->getBody());
    }

    public function testThatWrongDataWhileLoginWillReturnFailedStatus()
    {
        $this->register();
        Auth::logout();

        $params = array_merge($this->params, ['password' => 'ddd']);

        $request = $this->newRequest([
            'uri' => 'api/login',
            'method' => 'post',
            'content_type' => 'application/json'
        ], $params);

        $response = ($this->app)($request, new Response());

        $this->assertFalse(Auth::check());

        $expected = [
            'status' => 'fail',
            'code' => 301 // TODO: change code
        ];
        $expected = json_encode($expected);

        $this->assertEquals($expected, $response->getBody());
    }
}
