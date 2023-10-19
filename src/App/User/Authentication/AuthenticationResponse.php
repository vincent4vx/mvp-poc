<?php

namespace Quatrevieux\Mvp\App\User\Authentication;

use Quatrevieux\Mvp\App\User\AuthenticatedUser;

class AuthenticationResponse
{
    public function __construct(
        public readonly string $username,
        public readonly bool $success,
        public readonly ?AuthenticatedUser $user = null,
    ) {
    }
}
