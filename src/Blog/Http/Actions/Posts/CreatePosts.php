<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Posts;

use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\PostsRepositoryInterface;
use Tgu\Pakhomova\Blog\UUID;

class CreatePosts implements ActionInterface
{
public function __construct(
    private PostsRepositoryInterface $postsRepository
)
{
}

    public function handle(Request $request): Response
    {
        try {
            $uuid = UUID::random();
            $id = $request->query('uuid_post');
            $post = $this->postsRepository->getByUuidPost($uuid);
        }
        catch (HttpException | PostNotFoundException $exception ){
            return new ErrorResponse($exception->getMessage());
        }
        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>$id, 'uuid_author'=>$post->getUuidUser(), 'title'=>$post->getTitle(), 'text'=>$post->getTextPost()]);
    }
}