<?php
// Routes

$app->get('/comments', 'CommentController:index');
$app->options('/comments', function ($request, $response) {
	return $response
		->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
});