<?php

namespace Tgu\Pakhomova\Blog\Repositories\AuthTokenRepository;

use Tgu\Pakhomova\Blog\AuthToken;

interface AuthTokenRepositoryInterface
{
    public function save(AuthToken $authToken): void;
    public function get(string $token): AuthToken;
}