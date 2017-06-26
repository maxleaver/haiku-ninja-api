<?php
// Routes

$app->get('/comments', '\App\Controllers\CommentController:index');
$app->options('/comments', function ($request, $response) {
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
});

$app->get('/videos', '\App\Controllers\VideoController:index');
$app->options('/videos', function ($request, $response) {
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
});
