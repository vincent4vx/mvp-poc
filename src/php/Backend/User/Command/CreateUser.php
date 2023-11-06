<?php

namespace Quatrevieux\Mvp\Backend\User\Command;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

final class CreateUser
{
    public function __construct(
        public readonly Username $username,
        public readonly Pseudo $pseudo,
        public readonly Password $password,
        public readonly UserRolesSet $roles = new UserRolesSet(0),
    ) {
    }
}
