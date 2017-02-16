<?php

namespace App\Services;

use Google_Client;
use Google_Service_YouTube;

class YouTubeClient
{
    public $service;

    public function __construct()
    {
        // Instantiate Google API Client
        $client = new Google_Client();
        $client->setApplicationName(getenv('APP_NAME'));
        $client->setDeveloperKey(getenv('GOOGLE_API_KEY'));

        // Instantiate YouTube Service
        $this->service = new Google_Service_YouTube($client);
    }

    /**
     * Fetches top-level comments for a YouTube video
     * @param  string $part   Part parameter as specified in YouTube API
     * @param  array  $params Additional parameters for API request
     * @return array          Google API response
     */
    public function comments($part, $params)
    {
        return $this->service->commentThreads->listCommentThreads($part, $params);
    }
}
