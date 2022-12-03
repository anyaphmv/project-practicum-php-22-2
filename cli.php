<?php

use Tgu\Pakhomova\Blog\Commands\Arguments;
use Tgu\Pakhomova\Blog\Commands\CreateUserCommand;
use Tgu\Pakhomova\Blog\Comments;
use Tgu\Pakhomova\Blog\Exceptions\CommandException;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\InMemoryPostsRepository;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\SqlitePostRepository;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\InMemoryUsersRepository;
use Tgu\Pakhomova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Pakhomova\Blog\User;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\UUID;
use Tgu\Pakhomova\Person\Name;
use Tgu\Pakhomova\Blog\Exceptions\Argumentsexception;

$conteiner = require __DIR__ .'/bootstrap.php';
$command = $conteiner->get(CreateUserCommand::class);
try{$command->handle(Arguments::fromArgv($argv));}
catch (Argumentsexception|CommandException $exception){echo $exception->getMessage();}
//require_once __DIR__ .'/vendor/autoload.php';
//
//$connection = new PDO ('sqlite:'.__DIR__.'/blog.sqlite');
//$postRepository = new SqlitePostRepository($connection);
//$postRepository->savePost(new Post(UUID::random(), '7fba16a0-ca95-440d-b09a-94648029f2cc', 'Title1', 'Text1'));
//echo $postRepository->getByUuidPost(new UUID('937b59c7-e000-4eb6-acc7-850417c66010')) .PHP_EOL;
//$commentRepository = new SqliteCommentsRepository($connection);
//$commentRepository->saveComment(new Comments(UUID::random(), '937b59c7-e000-4eb6-acc7-850417c66010', '7fba16a0-ca95-440d-b09a-94648029f2cc', 'I am so tired'));
//echo $commentRepository->getByUuidComment(new UUID('5daad388-e5ed-4bc4-82a5-cea3e5544238')) .PHP_EOL;