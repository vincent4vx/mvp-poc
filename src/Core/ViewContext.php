<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

class ViewContext
{
    public string $content;

    public function __construct(
        public readonly ServerRequestInterface $request,
        public readonly object $query,
        public readonly object $response,
    ) {
    }
}
