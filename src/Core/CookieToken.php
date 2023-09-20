<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CookieToken implements SessionTokenInterface
{
    public function __construct(
        private readonly string $name = 'token',
        private readonly ?int $ttl = null,
    ) {
    }

    public function findToken(ServerRequestInterface $serverRequest): ?string
    {
        return $serverRequest->getCookieParams()[$this->name] ?? null;
    }

    public function writeToken(ResponseInterface $response, string $token, object $session): ResponseInterface
    {
        $cookie = [
            $this->name => $token,
            'Path' => '/',
            'HttpOnly' => true,
            'SameSite' => 'Strict',
        ];

        if ($this->ttl) {
            $cookie['Expires'] = gmdate('D, d M Y H:i:s T', time() + $this->ttl);
        }

        $header = '';

        foreach ($cookie as $key => $value) {
            if ($header) {
                $header .= '; ';
            }
            $header .= $key . '=' . $value;
        }

        return $response
            ->withAddedHeader('Set-Cookie', $header)
        ;
    }

    public function deleteToken(ResponseInterface $response, object $session): ResponseInterface
    {
        return $response
            ->withAddedHeader('Set-Cookie', $this->name . '=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT')
        ;
    }
}
