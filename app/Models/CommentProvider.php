<?php

namespace App\Models;

use Exception;
use App\Services\ICommentService;
use App\Services\HaikuService;

class CommentProvider
{
    protected $service;

    protected $id;
    protected $nextPageToken;
    protected $type;
    protected $comments;
    protected $commentsSearched = 0;
    protected $haiku;

    public function __construct(ICommentService $service, $id, $type, $nextPageToken = NULL)
    {
        $this->service = $service;
        $this->id = $id;
        $this->type = $type;
        $this->nextPageToken = $nextPageToken;

        $this->requestComments();
    }

    /**
     * Returns the ID for the Comment parent
     * @return string Comment parent ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the token for the next page of Comments
     * @return string Next page token
     */
    public function getNextPageToken()
    {
        return $this->nextPageToken;
    }

    /**
     * Sets the token for the next page of Comments
     * @param string $nextPageToken Token for next page of Comments
     */
    protected function setNextPageToken($nextPageToken)
    {
        $this->nextPageToken = $nextPageToken;
        return $this;
    }

    /**
     * Sets the array of Comments
     * @param array $comments Comments
     */
    protected function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }

    /**
     * Returns an array of Comments
     * @return array Comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Sets the number of comments searchd
     * @param int $searched Number of comments searched
     */
    protected function setCommentsSearched($searched)
    {
        $this->commentsSearched = $searched;
        return $this;
    }

    /**
     * Returns the number of comments searched
     * @return int Number of comments searched
     */
    public function getCommentsSearched()
    {
        return $this->commentsSearched;
    }

    /**
     * Requests comments from the Comment service provider
     * @return array Array of Comments
     */
    protected function requestComments()
    {
        // Request comments from the comment service
        $this->service->request($this->id, $this->nextPageToken);

        $this->setComments($this->service->getComments())
            ->setCommentsSearched($this->service->getCommentsSearched())
            ->setNextPageToken($this->service->getNextPageToken());

        return $this->comments;
    }
}
