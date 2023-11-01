<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Create;

use Quatrevieux\Mvp\Backend\User\Domain\User;

final class CreateUserResponse
{
    public function __construct(
        public readonly CreateUserRequest $request,
        public readonly bool $success,
        public readonly array $errors = [],
        public readonly ?User $user = null,
    ) {
    }
}
