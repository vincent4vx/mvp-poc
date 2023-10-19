<?php

namespace Quatrevieux\Mvp\Backend\User;

use Quatrevieux\Mvp\Backend\User\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\ValueObject\Username;

class UserCreation
{
    public function __construct(
        public readonly Username $username,
        public readonly Password $password,
        public readonly Pseudo $pseudo,
    ) {
    }

    public function created(UserId $id): User
    {
        return new User(
            id: $id,
            username: $this->username,
            password: $this->password,
            pseudo: $this->pseudo,
        );
    }
}
