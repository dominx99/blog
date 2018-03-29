<?php

return [
    'settings' => [
        'displayErrorsDetails' => true,
        'db' => [
            'development' => [
                'driver' => 'mysql',
                'host' => 'localhost',
                'database' => 'school',
                'username' => 'root',
                'password' => '',
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
