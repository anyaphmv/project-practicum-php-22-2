<?php

namespace Tgu\Pakhomova\Blog\Repositories\PostRepository;

use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\UUID;

class InMemoryPostsRepository implements PostsRepositoryInterface
{
    private array $posts = [];

    public function savePost(Post $post):void{
        $this->posts[] = $post;
    }

    public function getByUuidPost(UUID $uuidPost): Post
    {
        foreach ($this->posts as $post){
            if((string)$post->getUuid() === $uuidPost)
                return $post;
        }
        throw new PostNotFoundException("Posts not found $uuidPost");
    }
}