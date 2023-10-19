<?php

namespace Quatrevieux\Mvp\Backend\User;

use Quatrevieux\Mvp\Backend\User\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\ValueObject\Username;

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
