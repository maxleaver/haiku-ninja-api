<?php

namespace App\Services;

interface ICommentService
{
    public function request($for, $next);
    public function getComments();
    public function getNextPageToken();
    public function getCommentsSearched();
}
