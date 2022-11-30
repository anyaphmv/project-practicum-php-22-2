<?php

namespace Tgu\Pakhomova\Blog\Commands;

use Tgu\Pakhomova\Blog\Exceptions\CommandException;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\UUID;
use Tgu\Pakhomova\Person\Name;

class CreateUserCommand
{
    public function __construct(private UsersRepositoryInterface $usersRepository)
    {
    }

    public function handle(Arguments $arguments):void{
        $username = $arguments->get('username');
        if($this->userExist($username)){
            throw new CommandException("User already exists: $username");
        }
        $this->usersRepository->save(new User(UUID::random(), new Name($arguments->get('first_name'), $arguments->get('last_name')),$username));
    }
    public function userExist(string $username):bool{
        try{
            $this->usersRepository->getByUsername($username);
        }
        catch (UserNotFoundException $exception){
            return false;
        }
        return true;
    }
}