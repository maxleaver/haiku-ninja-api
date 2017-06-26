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

    protected function getErrorMessage($code)
    {
        return $this->ci->get('httpCodes')[$code] ?: $this->ci->get('httpCodes')[500];
    }

    protected function getResponse($response, $status, $body)
    {
        $response->getBody()->write(json_encode($body));

        return $response
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, OPTIONS')
            ->withStatus($status);
    }
}