<?php

namespace dominx99\school\Services\Database;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Illuminate\Database\Capsule\Manager;

class EloquentDatabaseProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $config = $container['settings']['db'];

        $capsule = new Manager();
        $capsule->addConnection([
            'driver'    => $config['driver'],
            'host'      => $config['host'],
            'database'  => $config['database'],
            'username'  => $config['username'],
            'password'  => $config['password'],
            'port'      => $config['port'],
            'charset'   => $config['charset'],
            'collation' => $config['collation'],
            'prefix'    => $config['prefix'],
        ]);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $container['db'] = function ($container) use ($capsule) {
            return $capsule;
        };
    }
}
