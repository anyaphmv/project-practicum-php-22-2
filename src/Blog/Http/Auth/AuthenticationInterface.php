<?php

namespace Tgu\Pakhomova\Blog\Http\Auth;

use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\User;

interface AuthenticationInterface
{
    public function user(Request $request):User;
    public function post(Request $request):Post;
}