<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Posts;

use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\PostsRepositoryInterface;

class DeletePost implements ActionInterface
{
    public function __construct(
        private PostsRepositoryInterface $postsRepository
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid_post');
            //$post = $this->postsRepository->getByUuidPost($uuid);
        }
        catch (HttpException | PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->getByUuidPost($uuid);
        return new SuccessResponse(['uuid_post'=>$uuid]);
    }
}