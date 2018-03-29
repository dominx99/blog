<?php

namespace dominx99\school;

use dominx99\school\Migration\Migration;

class Capsule
{
    protected static $capsule;

    public static function init()
    {
        $settings = require('bootstrap/settings.php');

        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($settings['settings']['db'][Config::get('environment')]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return self::$capsule = $capsule;
    }
}
