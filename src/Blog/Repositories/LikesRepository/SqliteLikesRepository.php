<?php

namespace Tgu\Pakhomova\Blog\Repositories\LikesRepository;

use PDO;
use PDOStatement;
use Tgu\Pakhomova\Blog\Exceptions\LikeNotFoundException;
use Tgu\Pakhomova\Blog\Likes;
use Tgu\Pakhomova\Blog\UUID;

class SqliteLikesRepository implements LikesRepositoryInterface
{
    public function __construct(private PDO $connection, private LoggerInterface $logger)
    {

    }

    public function saveLike(Likes $likes):void{
        $this->logger->info('Save like');
        $statement = $this->connection->prepare(
            "INSERT INTO likes (uuid_like, uuid_post, uuid_user) VALUES (:uuid_like,:uuid_post,:uuid_user)");
        $statement->execute([
            ':uuid_comment'=>(string)$likes->getUuidLike(),
            ':uuid_post'=>$likes->getUuidPost(),
            ':uuid_author'=>$likes->getUuidUser()]);
        $this->logger->info("'Save like: $likes" );
    }

    /**
     * @throws LikeNotFoundException
     */
    private function getLike(PDOStatement $statement, string $value):Likes{
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result===false){
            $this->logger->warning("Cannot get like: $value");
            throw new LikeNotFoundException("Cannot get like: $value");
        }
        return new Likes(new UUID($result['uuid_like']), $result['uuid_post'], $result['uuid_user']);
    }

    /**
     * @throws LikeNotFoundException
     */
    public function getByPostUuid(string $uuid_post): Likes
    {
        $statement = $this->connection->prepare(
            "SELECT * FROM likes WHERE uuid_post = :uuid_post"
        );
        $statement->execute([':uuid_post'=>$uuid_post]);
        return $this->getLike($statement, $uuid_post);
    }
}