<?php

namespace Tgu\Pakhomova\Blog\Repositories\LikesRepository;

use Tgu\Pakhomova\Blog\Likes;
use Tgu\Pakhomova\Blog\UUID;

interface LikesRepositoryInterface
{
    public function saveLike(Likes $comment):void;
    public function getByPostUuid(string $uuid_post): Likes;
}