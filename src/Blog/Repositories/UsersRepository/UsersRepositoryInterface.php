<?php

namespace Tgu\Pakhomova\Blog\Repositories\UsersRepository;

use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\UUID;

interface UsersRepositoryInterface
{
    public function save(User $user):void;
    public function getByUsername(string $username):User;
    public function getByUuid(UUID $uuid): User;
}