<?php

namespace App\Controllers;

use Exception;
use Monolog\Logger;
use App\Core\Controller;
use App\Services\YoutubeVideoService;


class VideoController extends Controller
{
    public function index($request, $response, $args)
    {
        try {
            $phrase = $request->getQueryParam('q');
            if (!isset($phrase) || empty($phrase)) {
                throw new Exception('A search phrase was missing from request', 422);
            }

            $youtube = new YoutubeVideoService();
            $result = $youtube->search($phrase);

            $status = 200;
            $body = [
                'items' => $youtube->getVideos(),
                'totalResults' => $youtube->getTotalResults(),
                'resultsPerPage' => $youtube->getResultsPerPage(),
                'nextPageToken' => $youtube->getNextPageToken()
            ];
        } catch (Exception $e) {
            $this->ci->logger->critical($e->getMessage());
            $this->ci->logger->error($e->getTraceAsString());

            // Set the status code and message
            $status = $e->getCode() ?: 500;
            $body = $this->getErrorMessage($e->getCode());
        }

        return $this->getResponse($response, $status, $body);
    }
}
