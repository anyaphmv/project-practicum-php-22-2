<?php

namespace Tgu\Pakhomova\Blog\Repositories\CommentsRepository;

use PDO;
use PDOStatement;
use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\Exceptions\CommentNotFoundException;
use Tgu\Pakhomova\Blog\UUID;

class SqliteCommentsRepository implements CommentsRepositoryInterface
{
    public function __construct(private PDO $connection, private LoggerInterface $logger,)
    {

    }

    public function saveComment(Comments $comment):void{
        $this->logger->info('Save comment ');
        $statement = $this->connection->prepare(
            "INSERT INTO comments (uuid_comment, uuid_post, uuid_author, textCom) VALUES (:uuid_comment,:uuid_post,:uuid_author, :textCom)");
        $statement->execute([
            ':uuid_comment'=>(string)$comment->getUuidComment(),
            ':uuid_post'=>$comment->getUuidPost(),
            ':uuid_author'=>$comment->getUuidUser(),
            ':textCom'=>$comment->getTextComment()]);
        $this->logger->info("'Save comment: $comment" );
    }

    /**
     * @throws CommentNotFoundException
     */
    private function getComment(PDOStatement $statement, string $value):Comments{
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            $this->logger->warning("Cannot get comment: $value");
            throw new CommentNotFoundException("Cannot get comment: $value");
        }
        return new Comments(new UUID($result['uuid_comment']), $result['uuid_post'], $result['uuid_author'], $result['textCom']);
    }

    public function getByUuidComment(UUID $uuid_comment): Comments
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM comments WHERE uuid_comment = :uuid_comment"
        );
        $statement->execute([':uuid_comment'=>(string)$uuid_comment]);
        return $this->getComment($statement, (string)$uuid_comment);
    }

    /**
     * @throws CommentNotFoundException
     */
    public function getTextComment(string $textCom):Comments
    {
        $statement = $this->connection->prepare("SELECT * FROM comments WHERE textCom = :textCom");
        $statement->execute([':textCom'=>(string)$textCom]);
        return $this->getComment($statement, $textCom);
    }
}