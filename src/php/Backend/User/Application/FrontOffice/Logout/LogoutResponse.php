<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Logout;

use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;

class LogoutResponse
{
    public function __construct(
        public readonly ?AuthenticatedUser $user = null,
    ) {
    }
}
