<?php

namespace TGU\Pakhomova\PhpUnit\Blog\Http\Actions\Users;

use PhpParser\Node\Expr\ErrorSuppress;
use PHPUnit\Framework\TestCase;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
use Tgu\Pakhomova\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\UUID;
use Tgu\Pakhomova\Person\Name;

class FindByUsernameActionTest extends TestCase
{
    private function userRepository(array $users):UsersRepositoryInterface{
        return new class($users) implements UsersRepositoryInterface{
          public function __construct(
              private array $users
          )
          {
          }

            public function save(User $user): void
            {
                // TODO: Implement save() method.
            }

            public function getByUsername(string $username): User
            {
                foreach ($this->users as $user){
                    if($user instanceof User && $username===$user->getUserName()){
                        return $user;
                    }
                }
                throw new UserNotFoundException('Not found');
            }

            public function getByUuid(UUID $uuid): User
            {
                throw new UserNotFoundException('Not found');
            }
        };
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIdNoUsernameProvided(): void
    {
        $request = new Request([], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request username"}');
        $responce->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIdUserNotFound(): void{
        $request = new Request(['username'=>'ivan'], [], '');
        $userRepository = $this->userRepository([]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $responce->send();
    }
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $request = new Request(['username'=>'ivan'], [],'');
        $userRepository = $this->userRepository([new User(UUID::random(),new Name('Ivan','Nilitin'),'ivan')]);
        $action = new FindByUsername($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(SuccessResponse::class, $responce);
        $this->expectOutputString('{"success":true,"data":{"username":"ivan","name":"Ivan Nilitin"}}');
        $responce->send();
    }
}