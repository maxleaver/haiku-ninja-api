<?php

namespace App\Services;

class HaikuService
{
    public $comments;
    protected $haiku;

    public function __construct(CommentService $comments)
    {
        $this->comments = $comments;
    }

    /**
     * Fetches comments from the comment service and builds the haiku array
     * @param  string $id            Unique identifier for comment service
     * @param  string $nextPageToken Optional token to use as offset for comments
     * @return array                 Comments that are also haiku
     */
    public function build($id, $nextPageToken = NULL)
    {
        $comments = $this->comments->fetchComments($id, $nextPageToken);
        return $this->setHaiku($comments);
    }

    /**
     * Filters out the comments that are also haiku
     * @param array $comments Comments that are also haiku
     */
    protected function setHaiku($comments)
    {
        $haikuArray = array_filter($comments, function ($comment) {
            if ($comment->isHaiku()) {
                return true;
            }

            return false;
        });

        $this->haiku = array_values($haikuArray);
        return $this->haiku;
    }

    /**
     * Returns array of comments that are also haiku
     * @return array Comments that are also haiku
     */
    public function getHaiku()
    {
        return $this->haiku;
    }
}
