<?php

namespace Quatrevieux\Mvp\Backend\User\AuthenticationForm;

class AuthenticationFormResponse
{
    public function __construct(
        public readonly ?string $error = null,
    ) {
    }
}
