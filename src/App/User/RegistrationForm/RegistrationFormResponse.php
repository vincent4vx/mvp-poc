<?php

namespace Quatrevieux\Mvp\App\User\RegistrationForm;

class RegistrationFormResponse
{
    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $pseudo = null,
        public readonly array $errors = [],
    ) {
    }
}
