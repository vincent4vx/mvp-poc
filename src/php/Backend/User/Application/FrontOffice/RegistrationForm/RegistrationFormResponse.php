<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\RegistrationForm;

class RegistrationFormResponse
{
    public function __construct(
        public readonly ?string $username = null,
        public readonly ?string $pseudo = null,
        public readonly array $errors = [],
    ) {
    }
}
