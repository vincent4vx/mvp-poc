<?php

namespace Quatrevieux\Mvp\Backend\User\Domain;

use DateTimeInterface;
use Quatrevieux\Mvp\Backend\Domain\Security\AuthenticatedUser;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Password;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Pseudo;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserId;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\Username;
use Quatrevieux\Mvp\Backend\User\Domain\ValueObject\UserRolesSet;

class User
{
    public function __construct(
        public readonly UserId $id,
        public readonly Username $username,
        public readonly Password $password,
        public readonly Pseudo $pseudo,
        public readonly UserRolesSet $roles,
    ) {
    }

    public function authenticate(string $inputPassword, string $pepper): ?AuthenticatedUser
    {
        return AuthenticatedUser::create($this, $inputPassword, $pepper);
    }

    public function adminAuthentication(string $inputPassword, DateTimeInterface $adminSessionExpiration, string $pepper): ?AuthenticatedUser
    {
        return AuthenticatedUser::createAdminSession($this, $adminSessionExpiration, $inputPassword, $pepper);
    }
}
