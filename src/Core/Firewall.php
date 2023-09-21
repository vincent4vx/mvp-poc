<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

class Firewall implements QueryValidatorInterface
{
    public function __construct(
        private readonly array $accessmap,
    ) {
    }

    public function validate(ServerRequestInterface $serverRequest, object $query): void
    {
        $validator = $this->accessmap[$query::class] ?? null;

        if (!$validator) {
            return;
        }

        if (!$validator($query, $serverRequest)) {
            throw new \Exception('Access denied');
        }
    }
}
