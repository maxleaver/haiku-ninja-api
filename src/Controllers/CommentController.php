<?php

namespace App\Controllers;

use Exception;
use App\Core\Controller;
use App\Services\HaikuServiceBuilder;
use Monolog\Logger;

class CommentController extends Controller
{
    public function index()
    {
        $statusCode = 200;

        try {
            // Get ID and next page token
            $id = $this->request->getQueryParam('id');
            $nextPageToken = $this->request->getQueryParam('nextPageToken');
            $type = $this->request->getQueryParam('type');

            if (!isset($id)) {
                throw new Exception('400 Bad Request', 400);
            }

            // Instantiate haiku service builder
            $service = new HaikuServiceBuilder($type);
            $service->haiku->build($id, $nextPageToken);

            // Set response body
            $this->response
                ->getBody()
                ->write(json_encode([
                    'comments' => $service->haiku->comments->getComments(),
                    'haiku' => $service->haiku->getHaiku(),
                    'nextPageToken' => $service->haiku->comments->getNextPageToken(),
                    'commentsSearched' => $service->haiku->comments->getCommentsSearched()
                ]));
        } catch (Exception $e) {
            $this->ci->logger->critical($e->getMessage());

            // Append error message to the response
            $this->response
                ->getBody()
                ->write($e->getMessage());

            // Set the status code
            $statusCode = $e->getCode();
        }

        // Set response headers and return response
        return $this->response
            ->withHeader('Content-type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->withStatus($statusCode);
    }
}
