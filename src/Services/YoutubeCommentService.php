<?php

namespace App\Services;

use App\Models\Comment;

class YoutubeCommentService implements CommentService {
    protected $youtube;
    protected $part = 'snippet';
    protected $textFormat = 'plainText';
    protected $maxResults = 100;
    protected $comments = array();
    protected $commentsSearched = 0;
    protected $nextPageToken;

    public function __construct(YoutubeClient $client)
    {
        $this->youtube = $client;
    }

    /**
     * Request comments from the YouTube API
     * @param  string $id            YouTube Video ID
     * @param  string $nextPageToken Token for page of results
     * @return array                 Array of Comment objects
     */
    public function fetchComments($id, $nextPageToken = NULL)
    {
        // Set parameters for YouTube API request
        $params = array(
            'videoId' => $id,
            'textFormat' => $this->textFormat,
            'maxResults' => $this->maxResults,
            'pageToken' => $nextPageToken
        );

        // Request comments from the YouTube API
        $results = $this->youtube->comments($this->part, $params);

        if (isset($results->items)) {
            // Set all the object properties
            $this->setNextPageToken($results->nextPageToken);
            $this->setCommentsSearched(count($results->items));
            $this->setComments($results->items);
        }

        return $this->comments;
    }

    /**
     * Convert YouTube API response into an array of comment objects
     * @param array $items YouTube API response
     */
    protected function setComments($items)
    {
        foreach ($items as $item) {
            // Parse through YouTube API response and build Comment objects
            if (isset($item->snippet) &&
                isset($item->snippet->topLevelComment) &&
                isset($item->snippet->topLevelComment->snippet)) {
                $data = $item->snippet->topLevelComment->snippet;
                $comment = new Comment($data->textDisplay, $data->authorDisplayName, $data->authorProfileImageUrl);

                // Add comment to comments property
                array_push($this->comments, $comment);
            }
        }
    }

    /**
     * Return array of comments
     * @return array Array of comment objects
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
     * @param int $count Comments searched
     */
    protected function setCommentsSearched($count)
    {
        $this->commentsSearched = $count;
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
