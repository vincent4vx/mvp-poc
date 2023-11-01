<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

class RoutedQuery
{
    public function __construct(
        public readonly ServerRequestInterface $request,
        public readonly object $query,
    ) {
    }

    public function withResponse(object $response): HandledQuery
    {
        return new HandledQuery($this->request, $this->query, $response);
    }
}
