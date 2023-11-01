<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Registration;

use Quatrevieux\Mvp\Backend\User\Domain\User;

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
