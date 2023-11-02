<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

class UserCreation
{
    public function __construct(
        public readonly Username $username,
        public readonly Password $password,
        public readonly Pseudo $pseudo,
        public readonly UserRolesSet $roles,
    ) {
    }

    public function created(UserId $id): User
    {
        return new User(
            id: $id,
            username: $this->username,
            password: $this->password,
            pseudo: $this->pseudo,
            roles: $this->roles,
        );
    }
}
