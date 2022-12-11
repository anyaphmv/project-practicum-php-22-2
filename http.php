<?php

use Psr\Log\LoggerInterface;
use Symfony\Component\Dotenv\Dotenv;
use Tgu\Pakhomova\Blog\Http\Actions\Comments\CreateComment;
use Tgu\Pakhomova\Blog\Http\Actions\Likes\CreateLikes;
use Tgu\Pakhomova\Blog\Http\Actions\Posts\CreatePost;
use Tgu\Pakhomova\Blog\Http\Actions\Posts\DeletePost;
use Tgu\Pakhomova\Blog\Http\Actions\Users\CreateUser;
use Tgu\Pakhomova\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\SqlitePostRepository;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\SqliteUsersRepository;

require_once __DIR__ . '/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->safeLoad();
var_dump($_SERVER);
die;
$conteiner = require __DIR__ . '/bootstrap.php';
$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));
$logger = $conteiner->get(LoggerInterface::class);
//$parameter = $request->query('some_param');
//$header = $request->header('Some-Header');
try {
    $path = $request->path();
} catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
try {
    $method = $request->method();
} catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
$routes = [
    'GET' => ['/users/show' => FindByUsername::class,
    ],
    'POST' => [
        '/users/create' => CreateUser::class,
        '/posts/create'=> CreatePost::class,
        '/comment/create'=> CreateComment::class,
        '/like/create'=> CreateLikes::class,
    ],
];
//$routes =[
//    'POST'=>[
//        '/posts/comment'=>new CreateComment(
//            new SqliteCommentsRepository(
//                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
//            )
//        )
//    ],
//    'DELETE'=>['/post/delete'=>new DeletePost(new SqlitePostRepository(new PDO('sqlite:'.__DIR__.'/blog.sqlite')))],
//];

if (!array_key_exists($path, $routes[$method])) {
    $message = "Route not found: $path $method";
    $logger->warning($message);
    (new ErrorResponse($message))->send();
    return;
}
$actionClassName = $routes[$method][$path];

$action = $conteiner->get($actionClassName);

try {
    $response = $action->handle($request);
    $response->send();
} catch (Exception $exception) {
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
//$user = new FindByUsername($request);
//$response = new SuccessResponse(['messages'=>'Hello']);
//$response->send();
//$response=new ErrorResponse('Error');
//$response->send();
//var_dump($parameter);
//var_dump($header);
//var_dump($path);
//echo 'Hello';