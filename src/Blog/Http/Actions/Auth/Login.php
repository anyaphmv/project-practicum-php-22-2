<?php

namespace Tgu\Pakhomova\Blog\Http\Actions\Auth;

use Tgu\Pakhomova\Blog\Http\Actions\ActionInterface;
use Tgu\Pakhomova\Blog\Http\Request;
use Tgu\Pakhomova\Blog\Http\Response;

class Login implements ActionInterface
{
    public function __construct(
        private PasswordAuthenticationInterface $passwordAuthentication,
        private AuthTokenRepositoryInterface $authTokenRepository,
    )
    {
    }
    public function handle(Request $request): Response
    {
        try {
            $user = $this->passwordAuthentication->user($request);
        }catch (AuthException $exception){
            return new ErrorResponse($exception->getMessage());
        }
        $authToken = new AuthToken(
            bin2hex(random_bytes(40)),
            $user->getUuid(),
            (new \DateTimeImmutable())->modify('+1 day')
        );
        $this->authTokenRepository->save($authToken);
        return new SuccessResponse([
            'token' =>(string)$authToken,
        ]);
    }
}