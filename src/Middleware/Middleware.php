<?php

namespace dominx99\school\Middleware;

class Middleware
{
    protected $container;

    public function __construct($container)
    {
        $this->container = $container;
    }
    
    public function __get($property)
    {
        return $this->container->{$property};
    }
}
