<?php

namespace App\Core;

class Controller
{
    protected $ci;
    protected $request;
    protected $response;

    public function __construct($ci)
    {
        $this->ci = $ci;
        $this->request = $ci->request;
        $this->response = $ci->response;
    }
}