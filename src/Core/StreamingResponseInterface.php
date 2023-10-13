<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;

interface StreamingResponseInterface
{
    public function response(): ResponseInterface;

    /**
     * @return iterable<string>
     */
    public function stream(): iterable;

    public function close(): void;

    public function end(): bool;
}
