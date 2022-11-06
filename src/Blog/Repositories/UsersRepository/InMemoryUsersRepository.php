<?php

namespace Blog\Repositories\UsersRepository;

use Blog\User;
use Tgu\Pakhomova\Exceptions\UserNotFoundException;

class InMemoryUsersRepository
{
    private array $users =[];
    public function save(User $user):void{
        $this->users[] = $user;
    }
    public function get(int $id):User {
        foreach ($this->users as $user){
            if($user->getId()==$id){
                return $user;
            }
        }
        throw new UserNotFoundException("User not found: $id");
    }
}