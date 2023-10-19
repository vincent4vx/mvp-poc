<?php

namespace Quatrevieux\Mvp\App\User;

use Quatrevieux\Mvp\App\User\ValueObject\Password;
use Quatrevieux\Mvp\App\User\ValueObject\Pseudo;
use Quatrevieux\Mvp\App\User\ValueObject\UserId;
use Quatrevieux\Mvp\App\User\ValueObject\Username;

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
