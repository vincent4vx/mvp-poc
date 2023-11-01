<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SessionHandler implements QueryValidatorInterface
{
    public function __construct(
        private readonly SessionTokenInterface $token,
        private readonly SessionResolverInterface $resolver,
    ) {
    }

    public function resolve(ServerRequestInterface $serverRequest): ?object
    {
        $token = $this->token->findToken($serverRequest);

        if (!$token) {
            return null;
        }

        return $this->resolver->resolve($token);
    }

    public function validate(ServerRequestInterface $serverRequest, object $query): void
    {
        if (!$query instanceof SessionBearerInterface) {
            return;
        }

        // @todo create session class & object
        $session = $this->resolve($serverRequest);

        if (!$session) {
            return;
        }

        $query->setSession($session);
    }

    public function write(ResponseInterface $response, object $session): ResponseInterface
    {
        $token = $this->resolver->generate($session);

        return $this->token->writeToken($response, $token, $session);
    }

    public function destroy(ResponseInterface $response, object $session): ResponseInterface
    {
        // @todo call resolver to destroy session
        return $this->token->deleteToken($response, $session);
    }
}
