<?php

// Settings to make all errors more obvious during testing
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('UTC');

define('PROJECT_ROOT', realpath(__DIR__ . '/..'));

require __DIR__ . '/../vendor/autoload.php';

// Load env variables
$dotenv = new Dotenv\Dotenv(__DIR__ . '/../');
$dotenv->load();

require __DIR__ . '/../tests/LocalWebTestCase.php';

/* End of file bootstrap.php */