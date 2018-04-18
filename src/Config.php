<?php

namespace dominx99\school;

class Config
{
    /**
     * @var string $environment stores information about which $environment will be used
     */
    protected static $environment;

    /**
     * @var string $jwtKey
     */
    protected static $jwtKey;

    /**
     * @param string $property
     * @param string $value
     * Function which has to set property of this class
     */
    public static function set($property, $value)
    {
        self::$$property = $value;
    }

    /**
     * @param string $property
     * @return string value of property
     * Function which has to return value of given property
     */
    public static function get($property)
    {
        if (empty(self::$$property)) {
            $config = require('bootstrap/config.php');
            self::$$property = $config[$property];
        }

        return self::$$property;
    }
}
