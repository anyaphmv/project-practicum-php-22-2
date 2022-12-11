<?php

namespace Tgu\Pakhomova\Blog\Repositories\PostRepository;

use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\UUID;

interface PostsRepositoryInterface
{
   public function savePost(Post $post):void;
   public function getByUuidPost(UUID $uuidPost): Post;
    public function getTextPost(string $text):Post;
}