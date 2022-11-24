<?php

namespace TGU\Pakhomova\PhpUnit\Repositories\PostRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\SqlitePostRepository;
use Tgu\Pakhomova\Blog\UUID;

class SqlitePostsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenPostNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostRepository($connectionStub);

        $this->expectException(PostNotFoundException::class);
        $this->expectExceptionMessage('Cannot get post: Text1');

        $repository->getTextPost('Text1');
    }

    public function testItSavePostToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_post' =>'937b59c7-e000-4eb6-acc7-850417c66010',
                ':uuid_author'=>'7fba16a0-ca95-440d-b09a-94648029f2cc',
                ':title'=>'Title1',
                ':text'=>'Text1']);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostRepository($connectionStub);

        $repository->savePost(new Post(
            new UUID('937b59c7-e000-4eb6-acc7-850417c66010'), '7fba16a0-ca95-440d-b09a-94648029f2cc','Title1','Text1'
        ));
    }

    public function testItUUidPosts():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqlitePostRepository($connectionStub);

        $this->expectException(PostNotFoundException::class);


        $repository->getByUuidPost('937b59c7-e000-4eb6-acc7-850417c66010');
    }
}