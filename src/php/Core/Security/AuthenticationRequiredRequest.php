<?php

namespace Quatrevieux\Mvp\Core\Security;

use Quatrevieux\Mvp\Core\QueryDecoratorInterface;

class AuthenticationRequiredRequest implements QueryDecoratorInterface
{
    public function __construct(
        public readonly object $target,
    ) {
    }

    public function previousQuery(): ?object
    {
        return $this->target;
    }
}
