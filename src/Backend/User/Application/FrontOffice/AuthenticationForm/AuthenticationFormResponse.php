<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\AuthenticationForm;

class AuthenticationFormResponse
{
    public function __construct(
        public readonly ?string $error = null,
    ) {
    }
}
