<?php

namespace Quatrevieux\Mvp\App\User\AuthenticationForm;

class AuthenticationFormRequest
{
    public function __construct(
        public ?string $error = null,
    ) {
    }
}
