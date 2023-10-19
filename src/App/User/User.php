<?php

namespace Quatrevieux\Mvp\App\User;

use Quatrevieux\Mvp\App\User\ValueObject\Password;
use Quatrevieux\Mvp\App\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\App\User\ValueObject\UserId;
use Quatrevieux\Mvp\App\User\ValueObject\Username;

class User
{
    public function __construct(
        public readonly UserId $id,
        public readonly Username $username,
        public readonly Password $password,
        public readonly Pseudo $pseudo,
    ) {
    }

    public function authenticate(string $inputPassword): ?AuthenticatedUser
    {
        return AuthenticatedUser::create($this, $inputPassword);
    }
}
