<?php

// Define root path
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

// Load .env file
$envFile = '.env';

if (PHP_SAPI == 'cli') {
    $envFile .= '.testing';
}

var_dump(PHP_SAPI);

if (file_exists($root . $envFile)) {
    $dotenv = new Dotenv\Dotenv($root, $envFile);
    $dotenv->load();
}

return [
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG'),
        'db' => [
            'driver'    => getenv('DB_CONNECTION'),
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_DATABASE'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'port'      => getenv('DB_PORT'),
            'charset'   => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION'),
            'prefix'    => getenv('DB_PREFIX'),
        ],
    ],
];
