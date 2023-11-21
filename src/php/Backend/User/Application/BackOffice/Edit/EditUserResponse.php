<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\Edit;

use Quatrevieux\Mvp\Backend\User\Domain\User;
use Quatrevieux\Mvp\Backend\User\Domain\UserRole;

class EditUserResponse
{
    public function __construct(
        public readonly User $user,
        public readonly ?string $pseudo = null,

        /**
         * @var array<UserRole>
         */
        public readonly array $roles = [],

        public readonly array $errors = [],
        public readonly ?string $globalError = null,
    ) {
    }
}
