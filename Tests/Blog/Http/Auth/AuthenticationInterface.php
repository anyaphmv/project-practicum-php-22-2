<?php

namespace TGU\Pakhomova\PhpUnit\Blog\Http\Auth;

use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request): User;
}