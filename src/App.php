<?php

namespace dominx99\school;

class App
{
    /**
     * @var \Slim\App $app variable which stores instance of Slim App
     */
    protected $app;

    /**
     * Function that creates Slim App instance from bootstrap files
     */
    public function __construct()
    {
        $settings = require __DIR__ . '/bootstrap/settings.php';
        $app = new \Slim\App($settings);

        $capsule = Capsule::init();

        require __DIR__ . '/bootstrap/dependency.php';
        require __DIR__ . '/routes/web.php';
        require __DIR__ . '/routes/api.php';

        $this->app = $app;
    }

    /**
     * @return \Slim\App $app
     * Function which returns instance of Slim App
     */
    public function boot()
    {
        return $this->app;
    }
}
