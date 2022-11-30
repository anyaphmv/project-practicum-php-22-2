<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Users;

use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\UUID;
use Tgu\Pakhomova\Person\Name;

class CreateUser implements ActionInterface
{
public function __construct(
    private UsersRepositoryInterface $usersRepository
)
{
}

    public function handle(Request $request): Response
    {
        try {
            $newUserUuid = UUID::random();
            $user = new User($newUserUuid,new Name($request->jsonBodyFind('first_name'), $request->jsonBodyFind('last_name')), $request->jsonBodyFind('username'));
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $this->usersRepository->save($user);
        return new SuccessResponse(['uuid'=>(string)$newUserUuid]);
    }
}