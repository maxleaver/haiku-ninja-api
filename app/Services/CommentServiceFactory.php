<?php

namespace App\Services;

use App\Exceptions\InvalidCommentServiceException;
use App\Services\ICommentService;

class CommentServiceFactory
{
	/**
     * Instantiates a comment service
     * @param string $source  Name of comment service
     */
    public function setService($source = null)
    {
        if (empty($source) || is_null($source)) {
            throw new InvalidCommentServiceException();
        }

        $serviceName = 'App\\Services\\' . ucfirst(strtolower($source)) . 'CommentService';

        if (class_exists($serviceName)) {
            // Instantiate the comment service
        	$service = new $serviceName;

        	if ($service instanceof ICommentService) {
        		return $service;
        	}
        }

        throw new InvalidCommentServiceException($source);
    }
}