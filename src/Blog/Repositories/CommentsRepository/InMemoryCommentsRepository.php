<?php

namespace Tgu\Pakhomova\Blog\Repositories\CommentsRepository;

use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\Exceptions\CommentNotFoundException;
use Tgu\Pakhomova\Blog\UUID;

class InMemoryCommentsRepository implements CommentsRepositoryInterface
{
    private array $comments = [];

    public function saveComment(Comments $comment):void{
        $this->comments[] = $comment;
    }

    public function getByUuidComment(UUID $uuid_comment): Comments
    {
        foreach ($this->comments as $comment){
            if((string)$comment->getUuid() === $uuid_comment)
                return $comment;
        }
        throw new CommentNotFoundException("Users not found $uuid_comment");
    }
}