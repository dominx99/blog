<?php

namespace dominx99\school;

use PHPUnit\Framework\TestCase;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\RequestBody;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;
use dominx99\school\App;
use dominx99\school\Config;

class BaseTestCase extends TestCase
{
    /**
     * @var \Slim\App
     */
    protected $app;

    protected $container;

    /**
     * Use middleware when running application?
     *
     * @var bool
     */
    protected $withMiddleware = true;

    public function setUp()
    {
        parent::setUp();
        Config::set('environment', 'testing');
        $this->createApplication();

        $traits = array_flip(class_uses_recursive(static::class));
        if (isset($traits[DatabaseTrait::class])) {
            $this->migrate();
        }
    }

    public function tearDown()
    {
        $traits = array_flip(class_uses_recursive(static::class));
        if (isset($traits[DatabaseTrait::class])) {
            $this->rollback();
        }
        unset($this->app);
        parent::tearDown();
    }

    /**
     * @return \Slim\App instance
     * Function which has only to call and create Slim App instance
     */
    public function createApplication()
    {
        $this->app = (new App)->boot();
        $this->container = $this->app->getContainer();
    }

    /**
     * @return \Slim\Http\Request
     * Function that creates and returns request created from params
     */
    public function newRequest($options = [], $params = [])
    {
        $default = [
            'content_type' => 'application/json',
            'method' => 'get',
            'uri' => '/'
        ];

        $options = array_merge($default, $options);

        $env = Environment::mock();
        $uri = Uri::createFromString($options['uri']);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $request = new Request($options['method'], $uri, $headers, $cookies, $serverParams, $body);

        $request = $request->withParsedBody($params);
        $request = $request->withHeader('Content-Type', $options['content_type']);
        $request = $request->withMethod($options['method']);

        return $request;
    }
}
