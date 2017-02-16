<?php
// Application middleware

$app->add(new \Slim\Middleware\JwtAuthentication([
    'attribute' => 'jwt',
    'secure' => false,
    'secret' => getenv('JWT_SECRET'),
    'algorithm' => ['HS256'],
    'logger' => $container['logger'],
    'rules' => [
        new \Slim\Middleware\JwtAuthentication\RequestPathRule([
            'path' => '/',
            'passthrough' => []
        ]),
        new \Slim\Middleware\JwtAuthentication\RequestMethodRule([
            'passthrough' => ['OPTIONS']
        ])
    ]
]));