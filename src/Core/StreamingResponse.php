<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ResponseInterface;

class StreamingResponse implements StreamingResponseInterface
{
    public function __construct(
        private readonly ResponseInterface $response,
        private readonly \Closure $streamer,
    ) {
    }

    public function response(): ResponseInterface
    {
        return $this->response;
    }

    public function stream(): iterable
    {
        return yield from ($this->streamer)();
    }

    public function close(): void
    {
        // NOOP
    }

    public function end(): bool
    {
        return false;
    }
}
