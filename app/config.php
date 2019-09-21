<?php

use App\Domain\Documents\DocumentRepositoryFactory;

return [
    'documents' => [
        'driver'  => DocumentRepositoryFactory::DRIVER_FS,
        //'driver'  => DocumentRepositoryFactory::DRIVER_MYSQL,
        'drivers' => [
            'fs' => [
                'directory' => __DIR__ . '/pages'
            ],
            'mysql' => [
                'dsn' => 'mysql:host=mysql;dbname=' . getenv('MYSQL_DATABASE'),
                'user' => getenv('MYSQL_USER'),
                'pass' => getenv('MYSQL_PASSWORD'),
            ]
        ]
    ],
    'templates' => __DIR__ . '/templates'
];