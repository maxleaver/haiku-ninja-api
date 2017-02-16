<?php

namespace App\Services;

use Exception;
use App\Services;

class HaikuServiceBuilder
{
    public $haiku;

    public function __construct($source)
    {
        $namespace = 'App\\Services\\';
        $serviceName = $namespace . ucfirst(strtolower($source)) . 'CommentService';
        $clientName = $namespace . ucfirst(strtolower($source)) . 'Client';

        if (!class_exists($serviceName)) {
            throw new Exception('Invalid comment service type: ' . $serviceName);
        }

        if (!class_exists($clientName)) {
            throw new Exception('Invalid comment service client: ' . $clientName);
        }

        // Build haiku service with comment service dependency
        $this->haiku = new HaikuService(
            new $serviceName(
                new $clientName()
            )
        );
    }
}
