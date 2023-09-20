<?php

namespace Quatrevieux\Mvp\App\User\Registration;

use Quatrevieux\Mvp\App\User\User;

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
