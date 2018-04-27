<?php

namespace dominx99\school\Auth;

use dominx99\school\BaseTestCase;
use dominx99\school\App;
use dominx99\school\Models\User;
use dominx99\school\DatabaseTrait;

class AuthTest extends BaseTestCase
{
    use DatabaseTrait;

    public function testThatAuthSetsSession()
    {
        $this->container->auth->authorize(5);
        $this->assertTrue(isset($_SESSION['user']));
    }

    public function testThatLogoutRemovesSession()
    {
        $this->container->auth->authorize(5);
        $this->container->auth->logout();
        $this->assertFalse($this->container->auth->user());
    }

    public function testThaCheckMethodWorks()
    {
        $this->container->auth->authorize(5);
        $this->assertTrue($this->container->auth->check());

        $this->container->auth->logout();
        $this->assertFalse($this->container->auth->check());
    }

    public function testThatAttemptionToLoginWorks()
    {
        $user = User::create([
            'email' => 'ddd@ddd.com',
            'name' => 'dddddd',
            'password' => password_hash('dddddd', PASSWORD_DEFAULT)
        ]);

        $result = $this->container->auth->attempt('ddd@ddd.com', 'dddddd');

        $this->assertTrue($result);
        $this->assertTrue($this->container->auth->check());
        $this->assertEquals($user->name, $this->container->auth->user()->name);
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

        $result = $this->container->auth->attempt($email, $password);

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
