<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit;

use Quatrevieux\Mvp\Backend\User\Domain\User;

class EditUserResponse
{
    public function __construct(
        public readonly User $user,
        public readonly ?string $pseudo = null,
        public readonly array $errors = [],
    ) {
    }
}
