<?php

namespace App\Services;

interface CommentService
{
    public function fetchComments($for, $next);
    public function getComments();
    public function getNextPageToken();
    public function getCommentsSearched();
}
