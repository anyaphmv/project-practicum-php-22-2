<?php

namespace TGU\Pakhomova\PhpUnit\Repositories\UsersRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Pakhomova\Blog\Exceptions\UserNotFoundException;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\UUID;
use Tgu\Pakhomova\Person\Name;
use TGU\Pakhomova\PhpUnit\Blog\DummyLogger;

class SqliteUsersRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenUserNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub,  new DummyLogger());

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Cannot get user: user1');

        $repository->getByUsername('user1');
    }

    public function testItSaveUserToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':first_name'=>'Petr',
                ':last_name'=>'Petrov',
                ':uuid' =>'0f07b4fe-cff9-4551-ba0c-d16bcbbbbe5e',
                ':username'=>'user2',
                ':password'=>'1234'
            ]);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub, new DummyLogger());

        $repository->save(new User(
            new UUID('0f07b4fe-cff9-4551-ba0c-d16bcbbbbe5e'),
            new Name('Petr', 'Petrov'), 'user2', '1234'
        ));
    }

    /**
     * @throws UserNotFoundException
     */
    public function testItUUidUser ():User
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteUsersRepository($connectionStub);
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage(' UUID: 0f07b4fe-cff9-4551-ba0c-d16bcbbbbe5e');

        $repository->getByUuid('0f07b4fe-cff9-4551-ba0c-d16bcbbbbe5e');
    }
}