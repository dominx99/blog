<?php

namespace dominx99\school\Controllers;

use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Request;

use dominx99\school\App;

class AuthControllerTest extends TestCase
{
    public function testController()
    {
        $this->assertTrue(true);

        $app = (new App('testing'))->boot();
        $container = $app->getContainer();

        $container['environment'] = function(){
            return Environment::mock([
                'REQUEST_URI' => '/auth',
                'REQUEST_METHOD' => 'POST',
                'QUERY_STRING' => 'abc=123&foo=bar',
            ]);
        };

        $response = $app->run(true);

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertSame($container->router->pathFor('home'), $response->getHeader('Location')[0]);

    }
}
