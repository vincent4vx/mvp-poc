<?php

namespace Quatrevieux\Mvp\Backend\User\Registration;

use Quatrevieux\Mvp\Backend\User\User;

class RegistrationResponse
{
    public function __construct(
        public readonly RegistrationRequest $request,
        public readonly bool $success,
        public readonly ?User $user,
        public readonly array $errors,
    ) {
    }
}
