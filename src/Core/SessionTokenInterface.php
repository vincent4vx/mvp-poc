<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface SessionTokenInterface
{
    public function findToken(ServerRequestInterface $serverRequest): ?string;

    public function writeToken(ResponseInterface $response, string $token, object $session): ResponseInterface;

    public function deleteToken(ResponseInterface $response, object $session): ResponseInterface;
}
