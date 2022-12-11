<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Likes;

use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
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
        private LikesRepositoryInterface $likesRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $newLikeUuid = UUID::random();
            $like= new Likes($newLikeUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_user'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
    }
}