<?php

namespace Quatrevieux\Mvp\Backend\User\Authentication;

use Quatrevieux\Mvp\Backend\User\AuthenticatedUser;

class AuthenticationResponse
{
    public function __construct(
        public readonly string $username,
        public readonly bool $success,
        public readonly ?AuthenticatedUser $user = null,
    ) {
    }
}
