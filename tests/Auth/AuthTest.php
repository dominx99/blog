<?php

namespace dominx99\school\Auth;

use PHPUnit\Framework\TestCase;
use dominx99\school\App;
use dominx99\school\Models\User;
use dominx99\school\Manager;

class AuthTest extends TestCase
{
    use Manager;

    public function setUp()
    {
        if(!isset($_SESSION) && !headers_sent()) {
           session_start();
       }
    }

    public function testThatAuthSetsSession()
    {
        Auth::authorize(5);
        $this->assertTrue(isset($_SESSION['user']));
    }

    public function testThatLogoutRemovesSession()
    {
        Auth::authorize(5);
        Auth::logout();
        $this->assertFalse(isset($_SESSION['user']));
    }

    public function testThaCheckMethodWorks()
    {
        Auth::authorize(5);
        $this->assertTrue(Auth::check());

        Auth::logout();
        $this->assertFalse(Auth::check());
    }

    public function testThatAttemptionToLoginWorks()
    {
        $this->migrate();

        $user = User::create([
            'email' => 'ddd@ddd.com',
            'name' => 'Dominik',
            'password' => password_hash('ddd', PASSWORD_DEFAULT)
        ]);

        $result = Auth::attempt('ddd@ddd.com', 'ddd');

        $this->assertTrue($result);
        $this->assertTrue(Auth::check());
        $this->assertEquals($user->name, Auth::user()->name);
    }
}
