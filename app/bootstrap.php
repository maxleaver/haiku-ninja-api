<?php
// Bootstrap

// Load env variables
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');

if (getenv('APP_ENV') === 'development' || getenv('APP_ENV') == false) {
	// Try to load a .env file
    $dotenv->load();
}

$dotenv->required([
	'APP_ENV',
	'APP_NAME',
	'GOOGLE_API_KEY'
]);