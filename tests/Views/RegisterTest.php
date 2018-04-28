<?php

namespace dominx99\school\Views;

use dominx99\school\BaseTestCase;

class RegisterTest extends BaseTestCase
{
    public function testGetLoginPage()
    {
        $response = $this->runApp('get', '/register');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Rejestracja', (string) $response->getBody());
        $this->assertContains($this->container->guard->getTokenNameKey(), (string) $response->getBody());
        $this->assertContains($this->container->guard->getTokenValueKey(), (string) $response->getBody());
    }
}
