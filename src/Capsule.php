<?php

namespace dominx99\school;

use Illuminate\Database\Capsule\Manager;
use dominx99\school\Migration\Migration;

class Capsule
{
    /**
     * @var \Illuminate\Database\Capsule\Manager $capsule strores this instance as static
     */
    protected static $capsule;

    /**
     * Function which has to create instance of Capsule according to .env file
     */
    public static function init()
    {
        $settings = require('bootstrap/settings.php');

        $capsule = new Manager;
        $capsule->addConnection($settings['settings']['db'][getenv('APP_ENV')]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return self::$capsule = $capsule;
    }

    public static function getCapsule()
    {
        return self::$capsule;
    }
}
