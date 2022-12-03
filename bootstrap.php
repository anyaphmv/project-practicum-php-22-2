<?php

use Tgu\Pakhomova\Blog\Container\DIContainer;
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
return $conteiner;