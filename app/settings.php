<?php
return [
    'settings' => [
        'displayErrorDetails' => false, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => getenv('APP_NAME'),
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
    ],
];
