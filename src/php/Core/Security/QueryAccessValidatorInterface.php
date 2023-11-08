<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Http\Message\ServerRequestInterface;

interface QueryAccessValidatorInterface
{
    /**
     * @param object $query
     * @param ServerRequestInterface $serverRequest
     */
    public function __invoke(object $query, ServerRequestInterface $serverRequest): AccessState;
}
