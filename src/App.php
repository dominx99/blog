<?php

namespace dominx99\school;

class App
{
    protected $app;

    public function __construct()
    {
        $settings = require __DIR__ . '/bootstrap/settings.php';
        $app = new \Slim\App($settings);

        $capsule = Capsule::init();

        require __DIR__ . '/bootstrap/dependency.php';
        require __DIR__ . '/bootstrap/routes.php';

        $this->app = $app;
    }

    public function boot()
    {
        return $this->app;
    }
}
