<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Tgu\Pakhomova\Blog\Container\DIContainer;
use Tgu\Pakhomova\Blog\Http\Auth\BearerTokenAuthentication;
use Tgu\Pakhomova\Blog\Http\Auth\PasswordAuthentication;
use Tgu\Pakhomova\Blog\Http\Auth\PasswordAuthenticationInterface;
use Tgu\Pakhomova\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Pakhomova\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Pakhomova\Blog\Repositories\AuthTokenRepository\SqliteAuthTokenRepository;
use Tgu\Pakhomova\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Pakhomova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Pakhomova\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Pakhomova\Blog\Repositories\LikesRepository\SqliteLikesRepository;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\PostsRepositoryInterface;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\SqlitePostRepository;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;

require_once  __DIR__ . '/vendor/autoload.php';
$conteiner = new DIContainer();
$conteiner->bind(
    PDO::class,
    new PDO('sqlite:'.__DIR__.'/blog.sqlite')
);
$conteiner->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class
);
$conteiner->bind(
    TokenAuthenticationInterface::class,
    BearerTokenAuthentication::class
);


$conteiner->bind(
    PasswordAuthenticationInterface::class,
    PasswordAuthentication::class
);
$conteiner->bind(
    LikesRepositoryInterface::class,
    SqliteLikesRepository::class
);


$conteiner->bind(
    AuthTokenRepositoryInterface::class,
    SqliteAuthTokenRepository::class
);

$conteiner->bind(
    PostsRepositoryInterface::class,
    SqlitePostRepository::class
);
//$conteiner->bind(
//    AuthenticationInterface::class,
//    PasswordAuthentication::class
//);
$conteiner->bind(
    CommentsRepositoryInterface::class,
    SqliteCommentsRepository::class
);
$conteiner->bind(
    LoggerInterface::class,
    (new Logger('blog'))->pushHandler(new StreamHandler(
        __DIR__.'/logs/blog.log',
    )) ->pushHandler(new StreamHandler(
        __DIR__.'/logs/blog.error.log',
        level: Logger::ERROR,
        bubble: false
    ))->pushHandler(new StreamHandler( "php://stdout"),
    ),
);
return $conteiner;