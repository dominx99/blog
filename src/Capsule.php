<?php

namespace dominx99\school;

use dominx99\school\Migration\Migration;

class Capsule
{
    protected static $capsule;

    public static function init($environment = 'development')
    {
        $settings = require('bootstrap/settings.php');

        Migration::setEnvironment($environment);
        echo $environment . "-";

        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($settings['settings']['db'][$environment]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return self::$capsule = $capsule;
    }
}
