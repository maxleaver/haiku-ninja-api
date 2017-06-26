<?php

namespace App\Services;

use Google_Client;
use Google_Service_YouTube;
use App\Models\Comment;
use App\Services\ICommentService;

class YoutubeCommentService implements ICommentService
{
    protected $service;

    protected $comments = [];
    protected $commentsSearched = 0;
    protected $nextPageToken;

    public function __construct($service = null)
    {
        $this->service = $service;

        if (is_null($this->service)) {
            $this->service = $this->getService();
        }
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

    /**
     * Request comments from the YouTube API
     * @param  string $id            YouTube Video ID
     * @param  string $nextPageToken Token for page of results
     * @return array                 Array of Comments
     */
    public function request($id, $nextPageToken = NULL)
    {
        // Set parameters for YouTube API request
        $params = [
            'videoId' => $id,
            'textFormat' => 'plainText',
            'maxResults' => 100,
            'pageToken' => $nextPageToken
        ];

        // Request comments from the YouTube API
        $response = $this->service->commentThreads->listCommentThreads('snippet', $params);

        if (isset($response->items)) {
            // Set all the object properties
            $this->setComments($response->items);
            $this->setNextPageToken($response->nextPageToken);
        }

        return $this->getComments();
    }

    /**
     * Convert YouTube API response into an array of comment objects
     * @param array $items YouTube API response
     */
    protected function setComments($items)
    {
        foreach ($items as $item) {
            // Parse through YouTube API response and build Comment objects
            if (isset($item->snippet->topLevelComment->snippet)) {
                $data = $item->snippet->topLevelComment->snippet;
                $comment = new Comment($data->textDisplay, $data->authorDisplayName, $data->authorProfileImageUrl);

                // Add comment to comments property
                array_push($this->comments, $comment);
            }
        }

        $this->setCommentsSearched();
    }

    /**
     * Returns the array of Comments
     * @return array Array of Comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set page token for next set of results
     * @param string $nextPageToken YouTube API page token
     */
    protected function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
    }

    /**
     * Return YouTube API page token
     * @return string YouTube API page token
     */
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    /**
     * Set the number of comments searched
     * @param array $items Array of Comments
     */
    protected function setCommentsSearched()
    {
        $this->commentsSearched = count($this->comments);
    }

    /**
     * Returns the number of comments searched
     * @return int Comments searched
     */
    public function getCommentsSearched()
    {
        return $this->commentsSearched;
    }
}
