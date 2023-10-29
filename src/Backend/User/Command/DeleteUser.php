<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\User;

class DeleteUser
{
    public function __construct(
        public readonly User $user,
    ) {
    }
}
