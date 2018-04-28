<?php

namespace dominx99\school\Views;

use dominx99\school\BaseTestCase;

class LoginTest extends BaseTestCase
{
    public function testGetLoginPage()
    {
        $response = $this->runApp('get', '/login');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Logowanie', (string) $response->getBody());
        $this->assertContains($this->container->guard->getTokenNameKey(), (string) $response->getBody());
        $this->assertContains($this->container->guard->getTokenValueKey(), (string) $response->getBody());
    }
}
