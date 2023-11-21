<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Save;

use Quatrevieux\Mvp\Backend\User\Domain\User;

final class SaveUserResponse
{
    public function __construct(
        public readonly SaveUserRequest $request,
        public readonly User $user,
        public readonly bool $success,
        public readonly array $errors = [],
        public readonly ?string $globalError = null,
    ) {
    }
}
