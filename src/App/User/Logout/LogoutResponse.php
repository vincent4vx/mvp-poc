<?php

namespace Quatrevieux\Mvp\App\User\Logout;

use Quatrevieux\Mvp\App\User\AuthenticatedUser;

class LogoutResponse
{
    public function __construct(
        public readonly ?AuthenticatedUser $user = null,
    ) {
    }
}
