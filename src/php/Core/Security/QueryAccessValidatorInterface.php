<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Http\Message\ServerRequestInterface;

interface QueryAccessValidatorInterface
{
    /**
     * @param object $query
     * @param ServerRequestInterface $serverRequest
     * @return bool
     */
    public function __invoke(object $query, ServerRequestInterface $serverRequest): bool;
}
