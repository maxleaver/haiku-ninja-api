<?php

namespace App\Controllers;

use Exception;
use App\Core\Controller;
use App\Exceptions\InvalidCommentServiceException;
use App\Models\CommentProvider;
use App\Services\CommentServiceFactory;
use App\Services\HaikuService;
use Monolog\Logger;

class CommentController extends Controller
{
    public function index($request, $response, $args)
    {
        try {
            $id = $request->getQueryParam('id');
            if (!isset($id) || empty($id)) {
                throw new Exception('ID missing from request', 422);
            }

            $type = $request->getQueryParam('type');
            if (!isset($type) || empty($type)) {
                throw new Exception('Type missing from request', 422);
            }

            $nextPageToken = $request->getQueryParam('nextPageToken');

            // Instantiate the comment service
            $service = (new CommentServiceFactory())->setService($request->getQueryParam('type'));

            // Instantiate the comment provider
            $provider = new CommentProvider($service, $id, $type, $nextPageToken);

            // Instantiate the Haiku service
            $haiku = (new HaikuService())->getHaiku($provider->getComments());

            $status = 200;
            $body = [
                'comments' => $provider->getComments(),
                'haiku' => $haiku,
                'nextPageToken' => $provider->getNextPageToken(),
                'commentsSearched' => $provider->getCommentsSearched()
            ];
        } catch (InvalidCommentServiceException $e) {
            $this->ci->logger->critical($e->getMessage());

            $status = 200;
            $body = $this->ci->get('httpCodes')[$status] . ': ' . $e->getMessage();
        } catch (Exception $e) {
            $this->ci->logger->critical($e->getMessage());

            // Set the status code and message
            $status = $e->getCode() ?: 500;
            $body = $this->getErrorMessage($e->getCode());
        }

        return $this->getResponse($response, $status, $body);
    }
}
