<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

class HandledQuery extends RoutedQuery
{
    public function __construct(
        ServerRequestInterface $request,
        object $query,
        public readonly object $response,
    ) {
        parent::__construct($request, $query);
    }
}
