<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Comments;

use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
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
        private CommentsRepositoryInterface $commentsRepository,
        private TokenAuthenticationInterface $authentication,
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $uuid_author = $this->authentication->user($request);
        } catch (UserNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        try {
            $uuid_post = $this->authentication->post($request);
        } catch (PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $newCommentUuid = UUID::random();
        try {
            $comment = new Comments($newCommentUuid,
                $uuid_post,
                $uuid_author,
                $request->jsonBodyField('textCom')
            );
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid_comment'=>(string)$newCommentUuid]);
    }
}