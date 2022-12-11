<?php

namespace TGU\Pakhomova\PhpUnit\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\Exceptions\CommentNotFoundException;
use Tgu\Pakhomova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Pakhomova\Blog\UUID;
use TGU\Pakhomova\PhpUnit\Blog\DummyLogger;

class SqliteCommentsRepositoryTest extends TestCase
{
    public function testItTrowsAnExceptionWhenCommentNotFound():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);

        $statementStub->method('fetch')->willReturn(false);
        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment: Qooooo');

        $repository->getTextComment('Qooooo');
    }

    public function testItSaveCommentsToDB():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createMock(PDOStatement::class);

        $statementStub
            ->expects($this->once())
            ->method('execute')
            ->with([
                ':uuid_comment' =>'5daad388-e5ed-4bc4-82a5-cea3e5544238',
                ':uuid_post'=>'937b59c7-e000-4eb6-acc7-850417c66010',
                ':uuid_author'=>'7fba16a0-ca95-440d-b09a-94648029f2cc',
                ':textCom'=>'I am so tired'
            ]);

        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub,
            new DummyLogger());

        $repository->saveComment( new Comments(
            new UUID('5daad388-e5ed-4bc4-82a5-cea3e5544238'), '937b59c7-e000-4eb6-acc7-850417c66010','7fba16a0-ca95-440d-b09a-94648029f2cc','I am so tired'
        ));
    }

    public function testItUUidComments():void
    {
        $connectionStub = $this->createStub(PDO::class);
        $statementStub =  $this->createStub(PDOStatement::class);


        $connectionStub->method('prepare')->willReturn($statementStub);

        $repository = new SqliteCommentsRepository($connectionStub, new DummyLogger());

        $this->expectException(CommentNotFoundException::class);
        $this->expectExceptionMessage('Cannot get comment:5daad388-e5ed-4bc4-82a5-cea3e5544238');

        $repository->getByUuidComment('5daad388-e5ed-4bc4-82a5-cea3e5544238');
    }
}