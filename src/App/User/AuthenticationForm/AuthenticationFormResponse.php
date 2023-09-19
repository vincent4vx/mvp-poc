<?php

namespace Quatrevieux\Mvp\App\User\AuthenticationForm;

class AuthenticationFormResponse
{
    public function __construct(
        public readonly ?string $error = null,
    ) {
    }
}
