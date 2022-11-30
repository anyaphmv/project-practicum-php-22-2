<?php

use Tgu\Pakhomova\Blog\Http\Actions\Comments\CreateComment;
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

require_once __DIR__ .'/vendor/autoload.php';
$request = new Request($_GET,$_SERVER,file_get_contents('php://input'));
//$parameter = $request->query('some_param');
//$header = $request->header('Some-Header');
try{
    $path=$request->path();
}
catch (HttpException $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
try {
    $method = $request->method();
}
catch (HttpException $exception){
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}
//$routes =[
//    'GET'=>['/users/show'=>new FindByUsername(new SqliteUsersRepository(new PDO('sqlite:'.__DIR__.'/blog.sqlite'))),],
//    'POST'=>[
//        '/users/create'=>new CreateUser(
//            new SqliteUsersRepository(
//                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
//            )
//        )
//    ],
//];
$routes =[
    'POST'=>[
        '/posts/comment'=>new CreateComment(
            new SqliteCommentsRepository(
                new PDO('sqlite:'.__DIR__.'/blog.sqlite')
            )
        )
    ],
    'DELETE'=>['/post/delete'=>new DeletePost(new SqlitePostRepository(new PDO('sqlite:'.__DIR__.'/blog.sqlite')))],
];

if (!array_key_exists($path,$routes[$method])){
    (new ErrorResponse('Not found'))->send();
    return;
}
$action = $routes[$method][$path];
try {
$response = $action->handle($request);
    $response->send();
}
catch (Exception $exception){
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