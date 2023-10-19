<?php

namespace Quatrevieux\Mvp\Backend\User\Logout;

use Quatrevieux\Mvp\Backend\User\AuthenticatedUser;

class LogoutResponse
{
    public function __construct(
        public readonly ?AuthenticatedUser $user = null,
    ) {
    }
}
