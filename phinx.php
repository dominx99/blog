<?php

$envFile = '.env';

if (isset($_SERVER['argv'][3])) {
    $envFile .= '.' . $_SERVER['argv'][3]; // .env.testing for example
}

$loader = new \dominx99\school\EnvLoader($envFile);
$loader->load();

require_once './vendor/autoload.php';
$settings = require './src/bootstrap/settings.php';
$app = new \Slim\App($settings);
$container = $app->getContainer();
$container->register(new \dominx99\school\Services\Database\EloquentDatabaseProvider());

var_dump($_ENV);
die();

return [
    'paths'                => [
        'migrations' => 'database/migrations',
        'seeds'      => 'database/seeds',
    ],
    'migration_base_class' => 'Migration',
    'templates'            => [
        'file' => 'src/Migration/Template.php.dist',
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_database'        => getenv('APP_ENV'),
        getenv('APP_ENV') => [
            'adapter'      => getenv('DB_CONNECTION'),
            'host'         => getenv('DB_HOST'),
            'name'         => getenv('DB_DATABASE'),
            'user'         => getenv('DB_USERNAME'),
            'pass'         => getenv('DB_PASSWORD'),
            'port'         => getenv('DB_PORT'),
            'charset'      => getenv('DB_CHARSET'),
            'collation'    => getenv('DB_COLLATION'),
            'table_prefix' => getenv('DB_PREFIX'),
            'memory' => true,
        ],
    ],
    'version_order' => 'creation',
];
