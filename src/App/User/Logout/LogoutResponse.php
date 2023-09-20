<?php

namespace Quatrevieux\Mvp\App\User\Logout;

use Quatrevieux\Mvp\App\User\User;

class LogoutResponse
{
    public function __construct(
        public readonly ?User $user = null,
    ) {
    }
}
