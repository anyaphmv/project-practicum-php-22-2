<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Users;

use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
use Tgu\Pakhomova\Blog\Http\Auth\AuthenticationInterface;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Pakhomova\Blog\User;

class FindByUsername implements AuthenticationInterface
{
    public function __construct(
        private UsersRepositoryInterface $usersRepository
    )
    {
    }

    public function handle(Request $request): Response
    {
        try {
            $username = $request->query('username');
            $user = $this->usersRepository->getByUsername($username);
        } catch (HttpException|UserNotFoundException $exception) {
            return new ErrorResponse($exception->getMessage());
        }
        return new SuccessResponse(['username' => $user->getUserName(), 'name' => $user->getName()->getFirstName() . ' ' . $user->getName()->getLastName()]);
    }

    public function user(Request $request): User
    {
        // TODO: Implement user() method.
    }

    public function post(Request $request): Post
    {
        // TODO: Implement post() method.
    }
}