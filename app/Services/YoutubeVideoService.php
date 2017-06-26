<?php

namespace App\Services;

use Exception;
use Google_Client;
use Google_Service_YouTube;
use App\Models\Video;

class YoutubeVideoService
{
    protected $service;
    protected $part = 'snippet';
    protected $maxResults = 50;

    protected $videos = [];
    protected $totalResults;
    protected $resultsPerPage;
    protected $nextPageToken;

    public function __construct($service = NULL)
    {
        $this->service = $service;

        if (is_null($this->service)) {
            $this->service = $this->getService();
        }
    }

    /**
     * Searches for videos using the YouTube API and returns the results
     * @param  string $phrase Search phrase
     * @return array          Array of Videos
     */
    public function search($phrase = NULL)
    {
        if (empty($phrase) || is_null($phrase)) {
            throw new Exception('A search phrase is required');
        }

        $results = $this->service->search->listSearch(
            $this->part,
            [
                'maxResults' => $this->maxResults,
                'q' => $phrase,
                'type' => 'video'
            ]
        );

        $this->setVideos($results->items);
        $this->setTotalResults($results->pageInfo->totalResults);
        $this->setResultsPerPage($results->pageInfo->resultsPerPage);
        $this->setNextPageToken($results->nextPageToken);

        return $this->videos;
    }

    /**
     * Set the array of Videos
     * @param array $items Array of search result items
     */
    protected function setVideos($items)
    {
        $this->videos = $this->convertItemsToVideoObjects($items);
    }

    /**
     * Converts Google search result items into an array Video objects
     * @param  array $items Google search result items
     * @return array        Array of Videos
     */
    protected function convertItemsToVideoObjects($items)
    {
        $videos = [];

        foreach($items as $item) {
            array_push($videos, new Video(
                $item->id->videoId,
                $item->snippet->title,
                $item->snippet->description
            ));
        }

        return $videos;
    }

    /**
     * Sets the total search results count
     * @param int $total Search result count
     */
    protected function setTotalResults($total)
    {
        $this->totalResults = $total;
    }

    /**
     * Sets the number of results per page for the search
     * @param int $count Search results per page
     */
    protected function setResultsPerPage($count)
    {
        $this->resultsPerPage = $count;
    }

    /**
     * Sets the next page token
     * @param string $token Next page token
     */
    protected function setNextPageToken($token)
    {
        $this->nextPageToken = $token;
    }

    /**
     * Returns the array of Videos
     * @return array Array of Videos
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Returns the total search results
     * @return int Total search results
     */
    public function getTotalResults()
    {
        return $this->totalResults;
    }

    /**
     * Returns the results per page for the search
     * @return int Search results per page
     */
    public function getResultsPerPage()
    {
        return $this->resultsPerPage;
    }

    /**
     * Returns the next page token
     * @return string Next page token
     */
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    /**
     * Returns an instance of the YouTube API service
     * @return Google_Service_YouTube     Google YouTube API Service
     */
    protected function getService()
    {
        // Instantiate Google API Client
        $client = new Google_Client();
        $client->setApplicationName(getenv('APP_NAME'));
        $client->setDeveloperKey(getenv('GOOGLE_API_KEY'));

        // Instantiate YouTube Service
        return new Google_Service_YouTube($client);
    }
}
