<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Comments;

use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Pakhomova\Blog\UUID;

class CreateComment implements ActionInterface
{
public function __construct(
    private CommentsRepositoryInterface $commentsRepository
)
{
}

    public function handle(Request $request): Response
    {
        try {
            $newCommentUuid = UUID::random();
            $comment = new Comments($newCommentUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_author'), $request->jsonBodyFind('textCom'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid'=>(string)$newCommentUuid]);
    }
}