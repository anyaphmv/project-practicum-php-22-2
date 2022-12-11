<?php

namespace Tgu\Pakhomova\Blog\Http\Auth;

use DateTimeImmutable;
use Tgu\Pakhomova\Blog\Exceptions\AuthException;
use Tgu\Pakhomova\Blog\Exceptions\AuthTokensRepositoryException;
use Tgu\Pakhomova\Blog\Exceptions\HttpException;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Post;
use Tgu\Pakhomova\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Pakhomova\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Pakhomova\Blog\User;

class BearerTokenAuthentication implements TokenAuthenticationInterface
{
    private  const HEADER_PREFIX = 'Bearer ';

    public function __construct(
        private AuthTokenRepositoryInterface $authTokenRepository,
        private UsersRepositoryInterface $usersRepository,
    )
    {
    }

    /**
     * @throws AuthException
     */
    public function user(Request $request): User
    {
        try {
            $header = $request->header('Authorization');
        }catch (HttpException $exception){
            throw new AuthException($exception->getMessage());
        }
        if(!str_starts_with($header, self::HEADER_PREFIX)){
            throw new AuthException("Malformed token:[$header]");
        }
        $token = mb_substr($header, strlen(self::HEADER_PREFIX));
        try {
            $authToken = $this->authTokenRepository->get($token);
        }catch (AuthTokensRepositoryException $exception){
            throw new AuthException("Bad token:[$token]");
        }
        if(!$authToken->getExpiresOn()<= new DateTimeImmutable()){
            throw new AuthException("Token expired:[$token]");
        }
        $userUUid = $authToken->getUseruuid();
        return $this->usersRepository->getByUuid($userUUid);
    }

    public function post(Request $request): Post
    {
        // TODO: Implement post() method.
    }
}