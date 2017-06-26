<?php

namespace App\Services;

use App\Models\Comment;

class HaikuService
{
    /**
     * Parses an array of comments and returns any that are haiku
     * @param  array $comments Array of Comments
     * @return array           Array of haiku
     */
    public function getHaiku($comments)
    {
        $haiku = array_filter($comments, function (Comment $comment) {
            return $comment->isHaiku();
        });

        return array_values($haiku);
    }
}
