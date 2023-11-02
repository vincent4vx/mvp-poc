<?php

namespace Quatrevieux\Mvp\Core\Security;

use Psr\Http\Message\ServerRequestInterface;

final class AnonymousAccess implements QueryAccessValidatorInterface
{
    public function __invoke(object $query, ServerRequestInterface $serverRequest): bool
    {
        return true;
    }
}
