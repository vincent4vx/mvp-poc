<?php

namespace Quatrevieux\Mvp\Backend\User\Application\FrontOffice\Authentication;

use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;

class AuthenticationResponse
{
    public function __construct(
        public readonly string $username,
        public readonly bool $success,
        public readonly ?AuthenticatedUser $user = null,
    ) {
    }
}
