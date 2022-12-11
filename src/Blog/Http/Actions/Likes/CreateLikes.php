<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Likes;

use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
use Tgu\Pakhomova\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;
use Tgu\Pakhomova\Blog\Likes;
use Tgu\Pakhomova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Pakhomova\Blog\UUID;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;

class CreateLikes implements ActionInterface
{
    public function __construct(
        private LikesRepositoryInterface $likesRepository,
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
        $newLikeUuid = UUID::random();
        try {
            $like = new Likes($newLikeUuid,
                $uuid_post,
                $uuid_author,
            );
        } catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
    }
}