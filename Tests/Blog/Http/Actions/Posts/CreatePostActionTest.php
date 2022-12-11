<?php

namespace TGU\Pakhomova\PhpUnit\Blog\Http\Actions\Posts;

use PHPUnit\Framework\TestCase;
use Tgu\Pakhomova\Blog\Exceptions\PostNotFoundException;
use Tgu\Pakhomova\Blog\Http\Actions\Posts\CreatePosts;
use Tgu\Pakhomova\Blog\Http\ErrorResponse;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\SuccessResponse;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\Repositories\PostRepository\PostsRepositoryInterface;
use Tgu\Pakhomova\Blog\UUID;

class CreatePostActionTest extends TestCase
{
    private function postRepository(array $posts):PostsRepositoryInterface{
        return new class($posts) implements PostsRepositoryInterface {
            public function __construct(
                public array $array
            )
            {
            }

            public function savePost(Post $post): void
            {
                // TODO: Implement save() method.
            }

            public function getByUuidPost(UUID $uuid): Post
            {
                throw new PostNotFoundException('Not found');
            }

            public function getTextPost(string $text): Post
            {
                // TODO: Implement getTextPost() method.
            }
        };
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIfNoUuid(): void
    {
        $request = new Request([], [], '');
        $postRepository = $this->postRepository([]);
        $action = new CreatePosts($postRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request uuid_post"}');
        $responce->send();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws \JsonException
     */
    public function testItReturnErrorResponceIfUUIDNotFound(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>$uuid], [], '');
        $userRepository = $this->postRepository([]);
        $action = new CreatePosts($userRepository);
        $responce = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $responce);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $responce->send();
    }
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disable
     * @throws \JsonException
     */
    public function testItReturnSuccessfulResponse(): void{
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>"$uuid"], [],'');
        $postRepository = $this->postRepository([new Post($uuid,'e1032486-361f-424f-bd4e-0489bcacd161','Header2','I want to rest')]);
        $action = new CreatePosts($postRepository);
        $responce = $action->handle($request);
        var_dump($responce);
        $this->assertInstanceOf(SuccessResponse::class, $responce);
        $this->expectOutputString('{"success":true,"data":{"uuid_post":"ivan"}}');
        $responce->send();
    }
}