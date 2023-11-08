<?php

namespace Quatrevieux\Mvp\Core\Security;

class AuthenticationRequiredRequest
{
    public function __construct(
        public readonly object $target,
    ) {
    }
}
