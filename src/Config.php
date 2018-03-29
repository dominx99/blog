<?php

namespace dominx99\school;

class Config
{
    protected static $environment;

    public static function set($property, $value)
    {
        self::$$property = $value;
    }

    public static function get($property)
    {
        if (empty(self::$$property)) {
            $config = require('bootstrap/config.php');
            self::$$property = $config[$property];
        }

        return self::$$property;
    }
}
