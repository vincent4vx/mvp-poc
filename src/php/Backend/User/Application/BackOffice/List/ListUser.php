<?php

namespace Quatrevieux\Mvp\Backend\User\Application\BackOffice\List;

use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

final class ListUser
{
    public function __construct(
        public readonly UserId $id,
        public readonly Username $username,
        public readonly Pseudo $pseudo,
        public readonly UserRolesSet $roles,
    ) {
    }
}
