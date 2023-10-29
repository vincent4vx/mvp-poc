<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

class ErroredRequest
{
    public function __construct(
        public readonly ServerRequestInterface $serverRequest,
        public readonly ?object $query,
        public readonly \Throwable $error,
    ) {
    }
}
