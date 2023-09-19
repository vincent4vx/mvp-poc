<?php

namespace Quatrevieux\Mvp\Core;

use Psr\Http\Message\ServerRequestInterface;

interface ViewContextFactoryInterface
{
    public function createContext(ServerRequestInterface $request, object $query, object $response): ViewContext;
}
