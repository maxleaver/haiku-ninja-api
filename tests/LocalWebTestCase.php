<?php

namespace Tests\Bootstrap;

// Initialize our own copy of the slim application
class LocalWebTestCase extends \There4\Slim\Test\WebTestCase
{
    public function getSlimInstance() {
      // Instantiate the app
      $settings = require __DIR__ . '/../app/settings.php';
      $app = new \Slim\App($settings);

      // Set up dependencies
      require __DIR__ . '/../app/dependencies.php';

      // Register middleware
      require __DIR__ . '/../app/middleware.php';

      // Register routes
      require __DIR__ . '/../app/routes.php';

      // Register constants
      require __DIR__ . '/../app/constants.php';

      return $app;
    }
}
