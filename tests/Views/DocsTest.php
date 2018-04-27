<?php

namespace dominx99\school\Views;

use dominx99\school\BaseTestCase;

class ValidatorTest extends BaseTestCase
{
    public function testGetDocsPage()
    {
        $response = $this->runApp('get', '/docs');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Documentation', (string) $response->getBody());
    }

    public function testPostDocsPageNotAllowed()
    {
        $response = $this->runApp('post', '/docs');

        $this->assertContains('Method not allowed', (string) $response->getBody());
        $this->assertEquals(405, $response->getStatusCode());
    }
}
