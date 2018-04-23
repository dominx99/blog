<?php

namespace dominx99\school;

use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Yaml\Yaml;
use Phinx\Config\Config as PhinxConfig;
use Phinx\Migration\Manager as PhinxManager;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\RequestBody;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Uri;

use dominx99\school\Models\User;

trait Manager
{
    protected $app;
    protected $container;

    public function create()
    {
        Config::set('environment', 'testing');
        $this->app = $this->createApplication();
        $this->container = $this->app->getContainer();
        $this->migrate();
    }

    /**
     * Function which has to migrate init Capsule as sqlite in memory
     * and migrate database
     */
    public function migrate()
    {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'phinx.yml';
        $file = file_get_contents($path);
        $configArray = Yaml::parse($file);

        $config = new PhinxConfig($configArray);
        $manager = new PhinxManager($config, new StringInput(' '), new NullOutput());

        $manager->migrate('testing');
    }

    /**
     * @return \Slim\App instance
     * Function which has only to call and create Slim App instance
     */
    public function createApplication()
    {
        return (new App)->boot();
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

    public function register()
    {
        $this->params = [
            'email' => 'ddd@ddd.com',
            'name' => 'ddd',
            'password' => 'dddddd'
        ];

        $request = $this->newRequest([
            'uri' => '/register',
            'method' => 'post',
        ], $this->params);

        return $response = ($this->app)($request, new Response());
    }
}
