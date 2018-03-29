<?php

namespace dominx99\school\Controllers;

class Controller
{
    /**
     * @var \Slim\Container $container stores instance
     */
    protected $container;

    /**
     * @param \Slim\Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * @param object $property
     */
    public function __get($property)
    {
        return $this->container->{$property};
    }
}
