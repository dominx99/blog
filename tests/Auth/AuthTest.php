<?php

namespace dominx99\school\Auth;

use PHPUnit\Framework\TestCase;
use dominx99\school\App;
use dominx99\school\Models\User;
use dominx99\school\Manager;

class AuthTest extends TestCase
{
    public function setUp()
    {
        if(!isset($_SESSION) && !headers_sent()) {
           session_start();
       }
    }

    public function testThatAuthSetsSession()
    {
        Auth::auth(5);
        $this->assertTrue(isset($_SESSION['user']));
    }

    public function testThatLogoutRemovesSession()
    {
        Auth::auth(5);
        Auth::logout();
        $this->assertFalse(isset($_SESSION['user']));
    }

    public function testThaCheckMethodWorks()
    {
        Auth::auth(5);
        $this->assertTrue(Auth::check());

        Auth::logout();
        $this->assertFalse(Auth::check());
    }

    public function testThatAttemptionToLoginWorks()
    {
        $capsule = \dominx99\school\Capsule::init('testing');
        (new Manager)->migrate();

        // $schema = $capsule->schema();
        //
        // $schema->create('users', function (\Illuminate\Database\Schema\Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('email');
        //     $table->string('name');
        //     $table->string('password');
        //     $table->timestamps();
        // });

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
