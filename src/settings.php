<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
        ],

        'displayErrorDetails' => true,

        'db' =>
        [
            'host' => 'sql111.byethost31.com',
            'user' => 'b31_17273471',
            'pass' => 'bahaha20.2.',
            'dbname' => 'b31_17273471_bikehelper',
        ],
    ],
];