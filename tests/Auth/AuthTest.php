<?php

namespace dominx99\school\Auth;

use PHPUnit\Framework\TestCase;
use dominx99\school\App;
use dominx99\school\Models\User;
use dominx99\school\Manager;

class AuthTest extends TestCase
{
    use Manager;

    public function __get($property)
    {
        return $this->container->{$property};
    }

    public function setUp()
    {
        if(!isset($_SESSION) && !headers_sent()) {
           session_start();
       }

       $this->create();
    }

    public function testThatAuthSetsSession()
    {
        $this->auth->authorize(5);
        $this->assertTrue(isset($_SESSION['user']));
    }

    public function testThatLogoutRemovesSession()
    {
        $this->auth->authorize(5);
        $this->auth->logout();
        $this->assertFalse($this->auth->user());
    }

    public function testThaCheckMethodWorks()
    {
        $this->auth->authorize(5);
        $this->assertTrue($this->auth->check());

        $this->auth->logout();
        $this->assertFalse($this->auth->check());
    }

    public function testThatAttemptionToLoginWorks()
    {
        $user = User::create([
            'email' => 'ddd@ddd.com',
            'name' => 'dddddd',
            'password' => password_hash('dddddd', PASSWORD_DEFAULT)
        ]);

        $result = $this->auth->attempt('ddd@ddd.com', 'dddddd');

        $this->assertTrue($result);
        $this->assertTrue($this->auth->check());
        $this->assertEquals($user->name, $this->auth->user()->name);
    }

    /**
     * @dataProvider wrongDataLoginProvider
     */
    public function testThatAttemtionWithWrongDataWontAuth($email, $password)
    {
        $user = User::create([
            'email' => 'ddd@ddd.com',
            'name' => 'dddddd',
            'password' => password_hash('dddddd', PASSWORD_DEFAULT)
        ]);

        $result = $this->auth->attempt($email, $password);

        $this->assertFalse($result);
    }

    public function wrongDataLoginProvider()
    {
        return [
            ['ddd.com', 'ddd'],
            ['ddd@ddd.com' , 'ddd'],
            ['ddd.com', 'dddddd']
        ];
    }
}
