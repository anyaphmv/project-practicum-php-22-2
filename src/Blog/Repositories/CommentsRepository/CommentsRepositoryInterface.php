<?php

namespace Tgu\Pakhomova\Blog\Repositories\CommentsRepository;

use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function saveComment(Comments $comment):void;
    public function getByUuidComment(UUID $uuid_comment): Comments;
}