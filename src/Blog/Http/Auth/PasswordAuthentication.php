<?php

namespace Tgu\Pakhomova\Blog\Http\Auth;

use Tgu\Pakhomova\Blog\Exceptions\AuthException;
use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Exceptions\InvalidArgumentException;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\UUID;

class PasswordAuthentication implements PasswordAuthenticationInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository,
    )
    {

    }

    /**
     * @throws AuthException
     */
    public function user(Request $request): User
    {
        try {
            $username = new UUID($request->jsonBodyField('username'));
        }catch (InvalidArgumentException | HttpException $exception){
            throw new AuthException($exception->getMessage());
        }
        try {
            $user = $this->usersRepository->getByUsername($username);
        }catch (UserNotFoundException $exception){
            throw new AuthException($exception->getMessage());
        }
        try {
            $password = $request->jsonBodyField('password');
        }catch (InvalidArgumentException | HttpException$exception){
            throw new AuthException($exception->getMessage());
        }


        if (!$user->checkPassword($password)){
            throw new AuthException('Wrong password');
        }
        return $user;
    }

    public function post(Request $request): Post
    {
        // TODO: Implement post() method.
    }
}