<?php

// Define root path
defined('ROOT') ?: define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR);

// Load .env file
if (file_exists(ROOT . '.env')) {
    $dotenv = new Dotenv\Dotenv(ROOT);
    $dotenv->load();
}

return [
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG'),
        'db' => [
            'development' => [
                'driver'    => getenv('DB_CONNECTION'),
                'host'      => getenv('DB_HOST'),
                'database'  => getenv('DB_DATABASE'),
                'username'  => getenv('DB_USERNAME'),
                'password'  => getenv('DB_PASSWORD'),
                'port'      => getenv('DB_PORT'),
                'charset' => 'utf8',
                'collation' => 'utf8_unicode_ci',
                'prefix' => 'school_'
            ],
            'testing' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => ''
            ]
        ],
    ],
];
