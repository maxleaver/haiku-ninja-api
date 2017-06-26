<?php

namespace App\Exceptions;

use Exception;

class InvalidCommentServiceException extends Exception
{
    /**
     * The comment service type
     */
    public $type;

    /**
     * Create a new exception instance.
     * @return void
     */
    public function __construct($type = null)
    {
        if (is_null($type)) {
        	parent::__construct('A valid service type is required');
        	$this->type = '';
        	return;
        }

        parent::__construct($type . ' is not a valid service type');

        $this->type = $type;
    }

}
