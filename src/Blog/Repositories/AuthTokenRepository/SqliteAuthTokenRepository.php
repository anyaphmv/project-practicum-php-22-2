<?php

namespace Tgu\Pakhomova\Blog\Repositories\AuthTokenRepository;

use DateTimeImmutable;
use PDO;
use PDOException;
use Tgu\Pakhomova\Blog\AuthToken;
use Tgu\Pakhomova\Blog\Exceptions\AuthTokensRepositoryException;
use Tgu\Pakhomova\Blog\UUID;

class SqliteAuthTokenRepository implements AuthTokenRepositoryInterface
{
    public function __construct(
        private PDO $connection,

    )
    {
    }

    public function save(AuthToken $authToken): void
    {
        $query = <<<'SQL'
     INSERT INTO  tokens (token, uuid_author, expires_on) values (:token, :uuid_author, :expires_on)
          ON CONFLICT (token) DO UPDATE SET expires_on = :expires_on
SQL;

        try {
            $statement = $this->connection->prepare($query);
            $statement->execute([
                'token' => (string)$authToken,
                'uuid_author' => (string)$authToken->getUseruuid(),
                'expires_on' => $authToken->getExpiresOn()->format(\DateTimeInterface::ATOM)
            ]);
        } catch (PDOException $exception) {
            throw new AuthTokensRepositoryException(
                $exception->getMessage(), (int)$exception->getCode(), $exception
            );
        }
    }

    public function get(string $token): AuthToken
    {
        try {
            $statement = $this->connection->prepare('SELECT * FROM token = :token');
            $statement->execute(['token' =>$token]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $exception){
            throw new AuthTokensRepositoryException(
                $exception->getMessage(), (int)$exception->getCode(), $exception
            );
        }
        if($result ===false){
            throw new AuthTokensRepositoryException("Cannot find token: $token");
        }
        try {
            return new AuthToken(
                $result['token'],
                new UUID($result['uuid_author']),
                new DateTimeImmutable($result['expires_on'])
            );
        }catch (\Exception $exception){
            throw new AuthTokensRepositoryException(
                $exception->getMessage(), (int)$exception->getCode(), $exception
            );
        }
    }
}